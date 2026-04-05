<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

final class FaqObserver
{
    public function saved(Faq $faq): void
    {
        Cache::forget('faq:public');
    }

    public function deleted(Faq $faq): void
    {
        Cache::forget('faq:public');
    }
}
