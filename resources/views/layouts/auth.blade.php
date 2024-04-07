<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/rt-plugins.css') }}">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="{{ asset('dashboard/css/app.css') }}">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    @stack('head')
</head>
<body class="font-inter skin-default" id="body_class">
<!-- [if IE]>
<p class="browserupgrade">
    You are using an
    <strong>outdated</strong> browser. Please

    <a href="https://browsehappy.com/">upgrade your browser</a> to improve
    your experience and security.

</p>
<![endif] -->
<div class="loginwrapper">
    <div class="lg-inner-column">
        <div class="left-column relative z-[1]">
            <div class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]">
                <img src="{{ asset('dashboard/images/auth/characters.webp') }}" alt="" class=" h-full w-full object-cover pointer-events-none">
            </div>
        </div>
        <div class="right-column  relative">
            <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                <div class="auth-box h-full flex flex-col justify-center">
                    <div class="flex justify-center h-auto">
                        <x-application-logo />
                    </div>
                    {{ $slot }}
                </div>
                <div class="auth-footer text-center">
                    &copy; 2024, {{ config('app.name') }} {{ __('All Rights Reserved') }}.
                    <br>
                    Developed by
                    <a href="https://github.com/notwonderful/aioncms" target="_blank" class="text-primary-500 font-semibold">
                        notwonderful
                    </a>
                    with ❤️
                </div>
            </div>
        </div>
    </div>
</div>
<!-- scripts -->
<script src="{{ asset('dashboard/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('dashboard/js/rt-plugins.js') }}"></script>
<script src="{{ asset('dashboard/js/app.js') }}"></script>
</body>
</html>
