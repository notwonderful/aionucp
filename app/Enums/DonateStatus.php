<?php

namespace App\Enums;

enum DonateStatus: string
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case FAILURE = 'fail';
}
