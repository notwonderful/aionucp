<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RuntimeException;

final class TeleportCooldownException extends RuntimeException
{
    public function __construct(
        public readonly Carbon $nextTeleportAt
    ) {
        parent::__construct('Teleport is on cooldown.');
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => __('Error! It will be possible to teleport again after :time', [
                'time' => $this->nextTeleportAt->diffForHumans(),
            ]),
            'next_teleport_at' => $this->nextTeleportAt->toIso8601String(),
        ], 422);
    }
}
