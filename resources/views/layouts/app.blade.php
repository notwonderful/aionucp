<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('dashboard/images/logo/favicon.png') }}">
    <!-- BEGIN: Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- END: Google Font -->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('dashboard/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/SimpleBar.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/app.css') }}">
    <!-- END: Theme CSS-->
    <script src="{{ asset('dashboard/js/settings.js') }}"></script>
</head>

<body class="font-inter" id="body_class">
<!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
<main class="app-wrapper">
    @include('partials.dashboard.sidebar')
    <!-- BEGIN: Settings -->
    <!-- Settings Toggle Button -->
    <button class="fixed ltr:md:right-[-29px] ltr:right-0 rtl:left-0 rtl:md:left-[-29px] top-1/2 z-[888] translate-y-1/2 bg-slate-800 text-slate-50 dark:bg-slate-700 dark:text-slate-300 cursor-pointer transform rotate-90 flex items-center text-sm font-medium px-2 py-2 shadow-deep ltr:rounded-b rtl:rounded-t" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas">
        <iconify-icon class="text-slate-50 text-lg animate-spin" icon="material-symbols:settings-outline-rounded"></iconify-icon>
        <span class="hidden md:inline-block ltr:ml-2 rtl:mr-2">{{ __('Settings') }}</span>
    </button>

    @include('partials.admin.modals.settings')

    <!-- End: Settings -->
    <div class="flex flex-col justify-between min-h-screen">
        <div>
            @include('partials.dashboard.header')

            <!-- END: Header -->
            <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
                <div class="page-content">
                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            @include('partials.dashboard.alert')
                            <div class=" space-y-5">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.dashboard.footer')

    </div>
</main>
<!-- scripts -->
<!-- Core Js -->
<script src="{{ asset('dashboard/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('dashboard/js/popper.js') }}"></script>
<script src="{{ asset('dashboard/js/tw-elements-1.0.0-alpha13.min.js') }}"></script>
<script src="{{ asset('dashboard/js/SimpleBar.js') }}"></script>
<script src="{{ asset('dashboard/js/iconify.js') }}"></script>
<!-- Jquery Plugins -->

<!-- app js -->
<script src="{{ asset('dashboard/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('dashboard/js/app.js') }}"></script>
</body>
</html>
