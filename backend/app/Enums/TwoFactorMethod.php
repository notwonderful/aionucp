<?php

declare(strict_types=1);

namespace App\Enums;

enum TwoFactorMethod: string
{
    case EMAIL = 'email';
    case APP = 'app';
}
