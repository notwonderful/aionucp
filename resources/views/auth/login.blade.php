<x-auth-layout>
    @push('head')
        <script>
            function onSubmit(token) {
                document.getElementById("loginForm").submit();
            }
        </script>
    @endpush

    <form id="loginForm" class="space-y-4" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="fromGroup">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email"
                          :value="old('email')"
                          required autofocus autocomplete="username" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="fromGroup">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex justify-between">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" class="hiddens" name="remember">
                <span class="text-slate-500 dark:text-slate-400 text-sm leading-6 capitalize px-1">{{ __('Remember me') }}</span>
            </label>
            <a class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
        </div>
        <button class="btn btn-dark block w-full text-center g-recaptcha"
                type="submit"
                data-sitekey="{{ config('services.recaptcha_v3.site_key') }}"
                data-callback="onSubmit"
                data-action="submitLogin">{{ __('Log in') }}</button>
    </form>
    <div class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-12 uppercase text-sm mt-2">
         <a href="{{ route('register') }}" class="text-slate-900 dark:text-white font-medium hover:underline">{{ __('Don\'t have an account?') }}</a>
    </div>

</x-auth-layout>
