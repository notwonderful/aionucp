<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Support\Str;

final class GenerateRecoveryCodes
{
    /** @return list<string> */
    public function execute(int $count = 8): array
    {
        $codes = [];

        for ($i = 0; $i < $count; $i++) {
            $codes[] = Str::upper(Str::random(4)).'-'.Str::upper(Str::random(4));
        }

        return $codes;
    }
}
