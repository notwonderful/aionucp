<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\GameServerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request, GameServerContract $gameServer): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        assert($user instanceof User);

        $user->setAttribute('balance', $gameServer->getBalance($user->aion_acc_id));

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(status: 204);
    }
}
