<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Simulation des places sans capteur réel (en production : cron `* * * * * php artisan schedule:run`)
Schedule::command('parking:simulate')->everyMinute()->withoutOverlapping();
