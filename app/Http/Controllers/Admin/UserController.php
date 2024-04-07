<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Auth\UpdateUserEmail;
use App\Actions\User\GetUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\AionAccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetUsersAction $getUsersAction): View
    {
        $users = $getUsersAction->execute();

        return view('pages.admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('pages.admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('pages.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user, UpdateUserEmail $updateUserEmail, AionAccountService $aionAccountService): RedirectResponse
    {
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;

            $updateUserEmail->handle($user, $request->validated('email'));
        }

        if (array_key_exists('balance', $request->validated())) {
            $newBalance = $request->validated('balance');
            $aionAccountService->setAccountBalance($user->aion_acc_id, $newBalance);
        }

        $user->save();

        return back()->with('success', __('The user has been successfully updated!'));
    }
}
