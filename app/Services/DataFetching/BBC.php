<?php

namespace App\Services\DataFetching;
use Illuminate\Support\Facades\Http;

class BBC extends BaseProvider implements DataFetchingInterface
{

    public function __construct(string $provider)
    {
        $this->provider = $provider;
        $this->populate();
    }

    protected function populate(): void
    {
        $this->url        = config('FetchingDataConfig.providers.' . $this->provider . '.url');
        $this->parameters = config('FetchingDataConfig.providers.' . $this->provider . '.parameters');
        $this->fullBackDBCheck = config('FetchingDataConfig.providers.' . $this->provider . '.fullBackDBCheck');
    }
    protected function fetch(): array
    {
        return $this->recursiveGetXML();
    }

    protected function recursiveGetXML(): array
    {
        $data = [];
        try {
            $response = Http::get($this->url, $this->parameters);
            $xml = simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);
            if(count($xml->channel->item))
            {
                $data = $xml->channel->item;
            }
        }
        catch (\Throwable  $e) {
            \Log::error("Error  " . $e->getMessage());
        }
        return $data;
    }
    protected function cleanData(array $rowData): array
    {
        $data_array = [];
        foreach ($rowData as $item) {
            $md5_title =  md5((string) $item->title);
            $data[$md5_title] = [
                'title'=>(string) $item->title,
                'md5_title'=>$md5_title,
                'description'=>(string) $item->description,
                'content'=>null,
                'url'=>(string) $item->link,
                'image_url'=>isset($item->children('media', true)->thumbnail)
                    ? (string) $item->children('media', true)->thumbnail->attributes()->url
                    : null,
                'publishedAt'=>date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
                'require_crawler'=>true,
                'data_response'=> null,// json_encode($item),
                'processed'=>false,
                'provider'=>$this->provider,
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
        }
        return $data_array;
    }
}
