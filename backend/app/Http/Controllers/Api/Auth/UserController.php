<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\GameServerContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function show(Request $request, GameServerContract $gameServer): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $user->setAttribute('balance', $gameServer->getBalance($user->aion_acc_id));

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }
}
