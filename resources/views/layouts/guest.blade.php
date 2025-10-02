<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ request()->route()->getName() }} | {{ config('app.name') }}</title>
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
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700;800&family=Raleway:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Preload AdminLTE CSS -->
    {{-- <link rel="preload" href="{{ asset('adminlte/css/adminlte.css') }}" as="style" /> --}}
    <!-- Third Party Plugin(OverlayScrollbars) -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" /> --}}
    <!-- Third Party Plugin(Bootstrap Icons) -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" /> --}}
    <!-- Required Plugin(AdminLTE) -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}" /> --}}
    <!--end::Accessibility Features-->
    <!-- Tailwind CDN (for auth pages specific styling) -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <!-- Tailwind via Vite (project-wide assets, keep for Breeze/etc.) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="min-h-screen antialiased bg-white text-slate-800">
  {{ $slot }}
  <!-- Third Party Plugin(OverlayScrollbars) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"></script> --}}
  <!-- Required Plugin(Popper for Bootstrap 5) -->
  {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script> --}}
  <!-- Required Plugin(Bootstrap 5) -->
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script> --}}
  <!-- Required Plugin(AdminLTE) -->
  {{-- <script src="{{ asset('adminlte/js/adminlte.js') }}"></script> --}}
  <!-- OverlayScrollbars Configure -->
  <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
          scrollbarTheme: 'os-theme-light',
          scrollbarAutoHide: 'leave',
          scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
          const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
          if (sidebarWrapper && window.OverlayScrollbarsGlobal && OverlayScrollbarsGlobal.OverlayScrollbars) {
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
</body>
</html>
