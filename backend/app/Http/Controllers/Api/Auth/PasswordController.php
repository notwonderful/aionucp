<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\UpdateUserPassword;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

final class PasswordController extends Controller
{
    public function update(Request $request, UpdateUserPassword $updateUserPassword): JsonResponse
    {
        /** @var array<string, string> $validated */
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();
        assert($user instanceof User);

        $updateUserPassword->execute($user, $validated['password']);

        return response()->json([
            'message' => __('Password updated successfully.'),
        ]);
    }
}
