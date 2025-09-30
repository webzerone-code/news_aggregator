<?php

namespace App\Services\DataProcess;

use App\Models\Category;
use App\Models\News;
use App\Models\RawDataModel;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class DataProcess implements IProcessInterface
{
    private array $categories = [];
    private int $chunk = 100;
    public function __construct(){
        $this->loadCategories();
        $this->loadUnProcessedData();
    }
    private function loadCategories() :void
    {
        $categories = Category::query()->get();
        foreach ($categories as $category) {
            $this->categories[$category->title] = ['id'=>$category->id, 'keywords'=>$category->keywords];
        }
    }
    private function loadUnProcessedData():void
    {
        $currentProvider = null;
        $require_crawler = true;
        $processedIDs = [];
        $cleanedData  = [];
        RawDataModel::query()->where('processed', false)->chunk($this->chunk, function ($rawData) use (&$currentProvider,&$require_crawler,&$processedIDs, &$cleanedData){

            foreach ($rawData as $data)
            {
                if($currentProvider != $data->provider)
                {
                    $currentProvider = $data->provider;
                    $require_crawler = config('FetchingDataConfig.'.$currentProvider.'.data-crawler');
                }
                $category    = $this->getDataCategories($data['title']);
                $content     = null;
                if($require_crawler)
                {
                    $htmlContent = $this->getNewsContent($data['url']);
                    $content     = $this->extractNewsContent($htmlContent);
                }
                else
                {
                    $content = $data['content'];
                }

                if($content != null)
                {
                    $cleanedData[] = [
                        'processed_record'=>$data['id'],
                        'title'         => $data['title'],
                        'category_id'      => $category,
                        'image'         => $data['image_url'],
                        'original_url'  => $data['url'],
                        'content'       => $content,
                        'published_at'   => $data['publishedAt'],
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }
                $processedIDs[] = $data['id'];
            }
        });

        $this->updateProcessedRecord($processedIDs);
        $this->insertProcessedRecord($cleanedData);

    }

    private function getDataCategories(string $title):int
    {
        $title = strtolower($title);
        foreach($this->categories as $categoryTitle)
        {
            foreach($categoryTitle['keywords'] as $category)
            {
                if(str_contains($title, strtolower($category)))
                {
                    return $categoryTitle['id'];
                }
            }
        }
        return 1;
    }

    private function getNewsContent(string $url):?string
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->body(); // full HTML content
            }
        } catch (\Throwable $e) {
            \Log::error("Error fetching URL {$url}: " . $e->getMessage());
        }

        return null;
    }

    private function extractNewsContent(string $html):?string
    {
        $crawler = new Crawler($html);

        // Example: select main article by <article> tag
        $content = $crawler->filter('article')->text();

        return $content;
    }

    private function updateProcessedRecord(array $ids):void
    {
        RawDataModel::query()->whereIn('id', $ids)->update(['processed' => true]);
    }

    private function insertProcessedRecord(array $data):void
    {
        News::query()->insert($data);
    }
}
