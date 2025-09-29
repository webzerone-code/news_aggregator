<?php

namespace App\Services;

use App\Models\RawDataModel;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

abstract class BaseProvider
{
    protected string $provider;
    protected string $url;
    protected array $parameters;

    protected int $parsePerPage = 10;
    protected int $maxPages = 10;
    protected int $timeIntervals = 2160;
    protected int $fullBackDBCheck = 24;

    protected abstract function fetch(): array;
    protected abstract function cleanData(array $rowData): array;

    protected function populate():void
    {
        $this->url             = config('FetchingDataConfig.providers.' . $this->provider . '.url');
        $this->parameters      = config('FetchingDataConfig.providers.' . $this->provider . '.parameters');
        $this->parsePerPage    = config('FetchingDataConfig.providers.' . $this->provider . '.parsePerPage');
        $this->maxPages        = config('FetchingDataConfig.providers.' . $this->provider . '.maxPages');
        $this->timeIntervals   = config('FetchingDataConfig.providers.' . $this->provider . '.timeIntervals');
        $this->fullBackDBCheck = config('FetchingDataConfig.providers.' . $this->provider . '.fullBackDBCheck');
    }

    protected function recursiveGet(callable $extractItems, callable $extractTotal): array
    {
        $page = 1;

        $data = [];
        while(true)
        {
            $this->parameters['page'] = $page;
            try {
                $response = Http::get($this->url, $this->parameters);
                if($response->successful()){

                    $items = $extractItems($response);
                    $total = $extractTotal($response);

                    $data = array_merge($data,$items);
                    if(count($items) < $this->parsePerPage || count($items) == 0)
                        break;

                    if($total > $this->parsePerPage)
                    {
                        $reminder = $total - ($page * $this->parsePerPage);
                        if($reminder <= 0 || $page == $this->maxPages)
                            break;
                        $page += 1;

                    }
                }
                else
                {
                    \Log::error("Request failed at page {$page}: " . $response->status());
                    break;
                }
            }
            catch (\Throwable  $e) {
                \Log::error("Error on page {$page}: " . $e->getMessage());
                break;
            }
        }
        return $data;
    }
    protected function checkDuplicates(array $data_array): array
    {
        $duplicates = RawDataModel::query()->where('created_at','>',Carbon::now()->subHours($this->fullBackDBCheck)->format('Y-m-d H:i:s'))->whereIn('md5_title',array_keys($data_array))->get()->keyBy('md5_title');
        return Arr::except($data_array, $duplicates->keys()->all());
    }
    protected function store(array $data):void
    {
        foreach (array_chunk($data, 500) as $chunk)
        {
            RawDataModel::query()->insert($chunk);
        }
    }
    public function run():void
    {
        $rawData = $this->fetch();
        $cleanData = $this->cleanData($rawData);
        $data = $this->checkDuplicates($cleanData);
        if(count($data))
            $this->store($data);
    }
}
