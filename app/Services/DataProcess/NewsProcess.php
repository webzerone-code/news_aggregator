<?php

namespace App\Services\DataProcess;

use App\Models\News;
use App\Models\RawDataModel;

class NewsProcess
{
    public function updateProcessedRecord(array $ids):void
    {
        RawDataModel::query()->whereIn('id', $ids)->update(['processed' => true]);
    }

    public function insertProcessedRecord(array $data):void
    {
        News::query()->insert($data);
    }
}
