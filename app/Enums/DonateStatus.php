<?php

declare(strict_types=1);

namespace App\Enums;

enum DonateStatus: string
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case FAILURE = 'fail';
}
