<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

final class WikiEntryObserver
{
    public function saved(Model $model): void
    {
        Cache::forget('wiki:public');
    }

    public function deleted(Model $model): void
    {
        Cache::forget('wiki:public');
    }
}
