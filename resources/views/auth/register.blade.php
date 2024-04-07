<x-auth-layout>
    @push('head')
        <script>
            function onSubmit(token) {
                document.getElementById("registerForm").submit();
            }
        </script>
    @endpush

    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex">
            <x-primary-button class="mt-2 g-recaptcha"
                              data-sitekey="{{ config('services.recaptcha_v3.site_key') }}"
                              data-callback="onSubmit"
                              data-action="submitRegister"
            >
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

        <div class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-12 uppercase text-sm mt-2">
            <a href="{{ route('login') }}" class="text-slate-900 dark:text-white font-medium hover:underline">
                {{ __('Already registered?') }}
            </a>
        </div>
</x-auth-layout>
