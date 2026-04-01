<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Auth\UpdateUserEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request, UpdateUserEmail $updateUserEmail): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        /** @var string $email */
        $email = $request->validated('email');
        $updateUserEmail->handle($user, $email);

        return response()->json([
            'data' => new UserResource($user->fresh()),
            'message' => 'Profile updated successfully.',
        ]);
    }
}
