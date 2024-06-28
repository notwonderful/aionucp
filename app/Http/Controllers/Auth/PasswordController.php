<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\UpdateUserPassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

final class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request, UpdateUserPassword $updateUserPassword): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $updateUserPassword->handle($request->user(), $validated['password']);

        return back()->with('status', 'password-updated');
    }
}
