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
</head>
<!--end::Head-->
<!--begin::Body-->
  {{ $slot }}
</html>
