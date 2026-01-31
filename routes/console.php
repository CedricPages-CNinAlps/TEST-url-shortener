<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/**
 * Display an inspiring quote.
 *
 * @return void
 */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Clean up expired short URLs.
 */
Schedule::command('shorturls:clean')->daily()->withoutOverlapping();
