<?php

namespace App\Console\Commands;

use App\Jobs\FetchingRawData;
use Illuminate\Console\Command;

class FetchDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-data-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fetchArray = config('FetchingDataConfig.providers');
        foreach ($fetchArray as $provider)
        {
            if(array_key_exists('name', $provider))
                FetchingRawData::dispatch($provider['name'])->onQueue($provider['name']);
        }
    }
}
