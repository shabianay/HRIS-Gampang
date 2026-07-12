<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HRIS Gampang') }}</title>
    <meta name="theme-color" content="#1470f5">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen">
        @include('layouts.navigation')
        @isset($header)
            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm">
                <div class="py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-xl font-bold text-slate-900">{{ $header }}</h1>
                </div>
            </header>
        @endisset
        <main class="flex-1">
            @isset($slot)
                {{ $slot }}
            @endisset
            @yield('content')
        </main>
    </div>
<x-toast-notification />
</body>
</html>
