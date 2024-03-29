<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://www.google.com/recaptcha/api.js"></script>

        @stack('head')
    </head>
    <body class="font-sans text-gray-900 antialiased"
          x-data="{ darkMode: localStorage.getItem('dark') === 'true'}"
          x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
          x-bind:class="{'dark': darkMode}"
          x-cloak
    >
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="mb-1.5">
                <x-theme-switcher />
            </div>
            <div>
                <a href="/" class="text-black dark:text-white text-2xl">
                    <x-application-logo />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
