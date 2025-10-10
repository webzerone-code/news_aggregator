<?php

namespace App\Services\DataPipeLine;

use App\Services\DataProcess\NewsProcess;

class NewsPersister
{
    private NewsProcess $newsProcess;

    public function __construct(NewsProcess $newsProcess)
    {
        $this->newsProcess = $newsProcess;
    }

    public function persist(array $processedIDs, array $cleanedData): void
    {
        if (!empty($processedIDs)) {
            $this->newsProcess->updateProcessedRecord($processedIDs);
        }

        if (!empty($cleanedData)) {
            $this->newsProcess->insertProcessedRecord($cleanedData);
        }
    }
}
