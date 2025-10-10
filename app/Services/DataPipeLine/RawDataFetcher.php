<?php

namespace App\Services\DataPipeLine;

use App\Models\RawDataModel;

class RawDataFetcher
{
    private int $chunk = 100;

    public function __construct(int $chunk = 100)
    {
        $this->chunk = $chunk;
    }

    public function fetchUnprocessed(callable $callback): void
    {
        RawDataModel::query()
            ->where('processed', false)
            ->chunk($this->chunk, $callback);
    }
}
