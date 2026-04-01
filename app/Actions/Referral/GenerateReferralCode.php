<?php

declare(strict_types=1);

namespace App\Actions\Referral;

use Illuminate\Support\Str;

class GenerateReferralCode
{
    public function __invoke(string $name): string
    {
        return md5($name.Str::random(5));
    }
}
