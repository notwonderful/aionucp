<?php

declare(strict_types=1);

namespace App\Enums;

enum WikiEntryType: string
{
    case TEXT = 'text';
    case TABLE = 'table';
    case CALLOUT = 'callout';
    case SPOILER = 'spoiler';
}
