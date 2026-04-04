<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Auth\UpdateUserProfile;
use App\Contracts\GameServerContract;
use App\DataTransferObjects\ProfileUpdateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request, UpdateUserProfile $updateUserProfile, GameServerContract $gameServer): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $updatedUser = $updateUserProfile->execute($user, ProfileUpdateData::fromRequest($request));
        $updatedUser->setAttribute('balance', $gameServer->getBalance($updatedUser->aion_acc_id));

        return response()->json([
            'data' => new UserResource($updatedUser),
            'message' => __('Profile updated successfully.'),
        ]);
    }
}
