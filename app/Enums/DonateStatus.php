<?php

namespace App\Enums;

enum DonateStatus: string
{
    case Success = 'success';
    case Pending = 'pending';
    case Canceled = 'canceled';
    case Failure = 'fail';
}
