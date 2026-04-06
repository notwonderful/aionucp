<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:record-online')
    ->hourly()
    ->withoutOverlapping()
    ->onOneServer();

Schedule::command('app:track-items')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->onOneServer();
