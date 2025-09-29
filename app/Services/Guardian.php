<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Guardian extends BaseProvider implements DataFetchingInterface
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
        $this->parameters['from-date'] = $from;
        $this->parameters['to-date']   = $to;
        $this->parameters['page-size'] = $this->parsePerPage;
        $this->parameters['page'] = 1;
        return $this->recursiveGet(fn($response) => $response->json()['response']['results'] ?? [],fn($response) => $response->json()['response']['total'] ?? 0);
    }

    protected function cleanData(array $rowData):array
    {
        $data_array = [];
        foreach($rowData as $data)
        {
            $md5_title =  md5($data['webTitle']);
            $data_array[$md5_title] = [
                'title'=>$data['webTitle'],
                'md5_title'=>$md5_title,
                'description'=>null,//$data['fields']['body'],
                'content'=>$data['fields']['bodyText'],
                'url'=>$data['webUrl'],
                'image_url'=>$data['fields']['thumbnail'] ?? null,
                'publishedAt'=>Carbon::parse($data['webPublicationDate'])->format('Y-m-d\TH:i:s'),
                'require_crawler'=>false,
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
