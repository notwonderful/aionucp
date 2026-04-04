<?php

declare(strict_types=1);

namespace App\Enums;

enum TicketPriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
}
