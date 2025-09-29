<?php

namespace App\Console\Commands;

use App\Jobs\ProcessDataJob;
use Illuminate\Console\Command;

class DataProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:data-process-command';

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
        ProcessDataJob::dispatch()->onQueue('data-process');
    }
}
