<?php

namespace App\Jobs;

use App\Services\DataFetchingInterface;
use App\Services\FetchFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class FetchingRawData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    private string $provider;
    public $tries = 1;
    public $timeout = 300;
    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(): void
    {
        FetchFactory::getProviders($this->provider)->run();
    }
}
