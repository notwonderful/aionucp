<div class="card-body flex flex-col p-6">
    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
        <div class="flex-1">
            <div class="card-title text-slate-900 dark:text-white">{{ __('Update Password') }}</div>
            <p class="mt-1 text-slate-900 dark:text-white">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div>
            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                {{ __('Your email address is unverified.') }}

                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
            @endif
        </div>
    @endif
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="card-text h-full space-y-4">
            <div class="input-area">
                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                <input id="current_password" name="current_password" type="password" class="form-control">
                @error('current_password')
                <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-text h-full space-y-4">
            <div class="input-area">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input id="password" name="password" type="password" class="form-control">
                @error('password')
                <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-text h-full space-y-4">
            <div class="input-area">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                @error('password_confirmation')
                <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn inline-flex justify-center btn-danger shadow-base2 mt-2">{{ __('Save') }}</button>
        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400"
            >{{ __('Saved.') }}</p>
        @endif
    </form>
</div>


