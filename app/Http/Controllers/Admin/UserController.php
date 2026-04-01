<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Auth\UpdateUserEmail;
use App\Actions\User\GetUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AionAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class UserController extends Controller
{
    public function index(GetUsersAction $getUsersAction): AnonymousResourceCollection
    {
        $users = $getUsersAction->execute();

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user, UpdateUserEmail $updateUserEmail, AionAccountService $aionAccountService): JsonResponse
    {
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;

            /** @var string $email */
            $email = $request->validated('email');
            $updateUserEmail->handle($user, $email);
        }

        if (array_key_exists('balance', $request->validated())) {
            /** @var int $newBalance */
            $newBalance = $request->validated('balance');
            $aionAccountService->setAccountBalance($user->aion_acc_id, $newBalance);
        }

        $user->save();

        return response()->json([
            'message' => __('The user has been successfully updated!'),
            'user' => new UserResource($user),
        ]);
    }
}
