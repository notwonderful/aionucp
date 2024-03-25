<?php

namespace App\Actions\Auth;

use App\DataTransferObjects\UserData;
use App\Models\User;
use App\Services\AionAccountService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUser
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    public function handle(UserData $userData): RedirectResponse
    {
        return DB::transaction(function () use ($userData) {
            $aionAccountId = $this->aionAccountService->create($userData);

            $user = User::create([
                'name' => $userData->name,
                'email' => $userData->email,
                'password' => Hash::make($userData->password),
                'aion_acc_id' => $aionAccountId,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        });
    }
}
