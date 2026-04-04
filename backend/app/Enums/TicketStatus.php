<?php

declare(strict_types=1);

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case WAITING = 'waiting';
    case CLOSED = 'closed';
}
