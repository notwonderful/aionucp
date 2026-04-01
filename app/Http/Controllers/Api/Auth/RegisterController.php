<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterUser;
use App\DataTransferObjects\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

final class RegisterController extends Controller
{
    public function store(RegisterRequest $request, RegisterUser $registerUser): JsonResponse
    {
        $userData = UserData::fromRequest($request);

        $user = $registerUser->handle($userData, $request->string('ref_code')->toString() ?: null);

        return response()->json([
            'data' => new UserResource($user),
        ], 201);
    }
}
