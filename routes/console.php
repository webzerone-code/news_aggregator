<?php

use App\Console\Commands\DataProcessCommand;
use App\Console\Commands\FetchDataCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::Command(FetchDataCommand::class)->everyThirtyMinutes();//everyThirtyMinutes();
Schedule::Command(DataProcessCommand::class)->everyThirtyMinutes();//everyThirtyMinutes();
//  php artisan horizon
// php artisan schedule:work
// php artisan  queue:work redis --queue=OpenAPI
