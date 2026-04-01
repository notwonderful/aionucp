<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Support\Carbon;
use RuntimeException;

final class TeleportCooldownException extends RuntimeException
{
    public function __construct(
        public readonly Carbon $nextTeleportAt
    ) {
        parent::__construct('Teleport is on cooldown.');
    }
}
