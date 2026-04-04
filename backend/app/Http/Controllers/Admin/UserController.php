<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\UpdateUserAction;
use App\DataTransferObjects\AdminUpdateUserData;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;

final class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = QueryBuilder::for(User::with('roles:id,name'))
            ->allowedFilters('name', 'email')
            ->allowedSorts('name', 'email', 'created_at')
            ->defaultSort('-created_at')
            ->paginate();

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load('roles:id,name'));
    }

    public function update(UserRequest $request, User $user, UpdateUserAction $updateUserAction): JsonResponse
    {
        $updateUserAction->execute($user, AdminUpdateUserData::fromRequest($request));

        return response()->json([
            'data' => new UserResource($user),
            'message' => __('The user has been successfully updated!'),
        ]);
    }

    public function assignRole(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'role' => ['required', 'string', Rule::enum(UserRole::class)],
        ]);

        $role = UserRole::from($request->string('role')->toString());

        // Prevent assigning super-admin role unless you are super-admin
        $currentUser = $request->user();
        assert($currentUser instanceof User);

        if ($role === UserRole::SUPER_ADMIN && ! $currentUser->hasRole(UserRole::SUPER_ADMIN)) {
            abort(403, __('Only super admins can assign the super admin role.'));
        }

        // Prevent modifying own role
        if ($currentUser->id === $user->id) {
            abort(403, __('You cannot change your own role.'));
        }

        $user->syncRoles($role->value);

        return response()->json([
            'data' => new UserResource($user->load('roles:id,name')),
            'message' => __('Role updated successfully.'),
        ]);
    }
}
