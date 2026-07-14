<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('attendance:check-daily', function () {
    $this->call(\App\Console\Commands\CheckDailyAttendance::class);
})->purpose('Mark employees without attendance as absent for the day');

// Schedule: run attendance check daily at 23:59
Schedule::command('attendance:check-daily')->dailyAt('23:59');
