<?php

namespace App\Http\Controllers;

use App\Actions\Auth\UpdateUserEmail;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

final class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, UpdateUserEmail $updateUserEmail): RedirectResponse
    {
        $user = $request->user();
        assert($user instanceof \App\Models\User);

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        /** @var string $email */
        $email = $request->validated('email');
        $updateUserEmail->handle($user, $email);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
