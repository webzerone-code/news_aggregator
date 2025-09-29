<?php

namespace App\Services\DataFetching;

use Carbon\Carbon;

class OpenApi extends BaseProvider implements DataFetchingInterface
{
    public function __construct(string $provider)
    {
        $this->provider = $provider;
        parent::populate();
    }


    protected function fetch(): array
    {
        $from = Carbon::now()->subMinutes($this->timeIntervals)->setTimezone('UTC')->format('Y-m-d\TH:i:s');
        $to   = Carbon::now()->setTimezone('UTC')->format('Y-m-d\TH:i:s');
        $this->parameters['from'] = $from;
        $this->parameters['to']   = $to;
        $this->parameters['page'] = 1;
        return $this->recursiveGet(fn($response) => $response->json()['articles'] ?? [], fn($response) => $response->json()['totalResults'] ?? 0);
    }

    protected function cleanData(array $rowData):array
    {
        $data_array = [];
        foreach($rowData as $data)
        {
            $md5_title =  md5($data['title']);
            $data_array[$md5_title] = [
                'title'=>$data['title'],
                'md5_title'=>$md5_title,
                'description'=>$data['description'],
                'content'=>$data['content'],
                'url'=>$data['url'],
                'image_url'=>$data['urlToImage'],
                'publishedAt'=>Carbon::parse($data['publishedAt'])->format('Y-m-d\TH:i:s'),
                'require_crawler'=>true,
                'data_response'=>json_encode($data),
                'processed'=>false,
                'provider'=>$this->provider,
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
        }
        return $data_array;
    }

}
