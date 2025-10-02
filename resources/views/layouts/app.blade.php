<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head> --}}
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    {{-- <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" /> --}}
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="Aplikasi Kasir Tj" />
    <meta name="author" content="gntrr_" />
    <meta name="description"
        content="Aplikasi Kasir Tj adalah aplikasi kasir berbasis web yang dirancang untuk mempermudah proses transaksi penjualan dan pembelian." />
    <meta name="keywords"
        content="bootstrap 5, aplikasi kasir, aplikasi kasir berbasis web, aplikasi kasir online, aplikasi kasir gratis, aplikasi kasir terbaik, aplikasi kasir sederhana, aplikasi kasir toko, aplikasi kasir restoran, aplikasi kasir cafe, aplikasi kasir android, aplikasi kasir ios" />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('adminlte/css/adminlte.css') }}" as="style" />
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Archivo+Black&family=Lexend:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>
{{-- <body class="font-sans antialiased">
            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </body> --}}

<body class="bg-slate-50 overflow-x-hidden font-sans">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main id="content" class="pt-14 lg:ml-56 transition-[margin] duration-300">
        @if (session('error'))
            <div class="mx-4 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('success'))
            <div class="mx-4 mt-4">
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            </div>
        @endif
        {{ $slot }}
    </main>

    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    

    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <!--end::Script-->
    @stack('scripts')

    <!-- Sidebar Toggle Script -->
    <script>
        (function() {
            const btn = document.getElementById('sidebar-toggle'); // dari navigation.blade.php
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const content = document.getElementById('content');
            const navbar = document.getElementById('navbar');
            const DESKTOP = window.matchMedia('(min-width: 1024px)'); // lg breakpoint Tailwind

            // Default: open on desktop, closed on mobile; if user has saved preference, use it
            const saved = localStorage.getItem('sidebarOpen');
            let open = (saved === null) ? DESKTOP.matches : (saved === '1');

            function syncUI() {
                // slide in/out
                sidebar.classList.toggle('-translate-x-full', !open);

                // backdrop hanya tampil di non-desktop
                const showBackdrop = open && !DESKTOP.matches;
                backdrop.classList.toggle('hidden', !showBackdrop);

                // di desktop, konten geser 14rem (w-56)
                const offset = (open && DESKTOP.matches) ? '14rem' : '0';
                content.style.marginLeft = offset;
                if (navbar) navbar.style.left = offset;

                localStorage.setItem('sidebarOpen', open ? '1' : '0');
            }

            // initial paint
            syncUI();

            // toggle via hamburger
            btn?.addEventListener('click', () => {
                open = !open;
                syncUI();
            });

            // klik backdrop utk close
            backdrop.addEventListener('click', () => {
                open = false;
                syncUI();
            });

            // kalau user resize, sinkron lagi
            DESKTOP.addEventListener('change', () => {
                // On breakpoint change, reset to defaults per device
                open = DESKTOP.matches; // open on desktop, close on mobile
                syncUI();
            });
        })();
    </script>
</body>
<!--end::Body-->

</html>
