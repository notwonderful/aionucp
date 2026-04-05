<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\ScheduleEntry;
use Illuminate\Support\Facades\Cache;

final class ScheduleEntryObserver
{
    public function saved(ScheduleEntry $entry): void
    {
        Cache::forget('schedule:public');
    }

    public function deleted(ScheduleEntry $entry): void
    {
        Cache::forget('schedule:public');
    }
}
