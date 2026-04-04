<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

final class TeleportException extends RuntimeException
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => __('Teleport failed. Please try again later.'),
        ], 422);
    }
}
