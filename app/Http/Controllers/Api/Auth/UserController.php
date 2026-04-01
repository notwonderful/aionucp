<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }
}
