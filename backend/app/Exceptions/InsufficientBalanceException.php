<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class InsufficientBalanceException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('Not enough balance to purchase.'));
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 422);
    }
}
