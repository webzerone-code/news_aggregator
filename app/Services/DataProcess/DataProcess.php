<?php

namespace App\Services\DataProcess;
use App\Models\RawDataModel;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;


class DataProcess implements IProcessInterface
{
    private CategoriesProcess $categories;
    private NewsProcess $newsProcess;
    private CrawlerProcess $crawler;
    private int $chunk = 100;
    public function __construct(CategoriesProcess $categories, NewsProcess $newsProcess,CrawlerProcess $crawler){
        $this->categories = $categories;
        $this->newsProcess = $newsProcess;
        $this->crawler = $crawler;
    }

    public function handle():void
    {
        $currentProvider = null;
        $require_crawler = true;
        $processedIDs = [];
        $cleanedData  = [];

        RawDataModel::query()->where('processed', false)->chunk($this->chunk, function ($rawData) use (&$currentProvider,&$require_crawler,&$processedIDs, &$cleanedData){

            foreach ($rawData as $data)
            {
                try {
                    if($currentProvider != $data->provider)
                    {
                        $currentProvider = $data->provider;
                        $require_crawler = config('FetchingDataConfig.'.$currentProvider.'.data-crawler');
                    }
                    $category    = $this->categories->getDataCategories($data['title']);
                    $content     = null;
                    if($require_crawler)
                    {
                        $htmlContent = $this->crawler->getNewsContent($data['url']);//
                        $content     = $this->crawler->extractNewsContent($htmlContent);
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
                catch (\Throwable $e){
                    Log::error('Failed to process Record',[
                        'id'=>$data['id'],
                        'error'=>$e->getMessage(),
                    ]);
                }
            }
        });
        $this->newsProcess->updateProcessedRecord($processedIDs);
        $this->newsProcess->insertProcessedRecord($cleanedData);
    }
}
