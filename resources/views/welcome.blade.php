<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="HRIS Gampang — Solusi manajemen HR paling sederhana untuk bisnis Indonesia. Kelola data pegawai, cuti, absensi, dan payroll dalam satu platform.">
    <meta name="keywords" content="HRIS Indonesia, manajemen pegawai, HR software, payroll online, aplikasi cuti, absensi karyawan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="HRIS Gampang — Manajemen Kepegawaian Modern & Mudah">
    <meta property="og:description" content="Platform HR all-in-one untuk bisnis Indonesia. Gratis selamanya.">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#1470f5">

    <title>{{ config('app.name', 'HRIS Gampang') }} — Manajemen HR Modern & Mudah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="canonical" href="{{ url('/') }}" />
</head>
<body>

<div x-data="{
    scrolled: false,
    mobileOpen: false,
    init() {
        window.addEventListener('scroll', () => { this.scrolled = window.scrollY > 50 });
    }
}" class="min-h-screen bg-white text-slate-900 overflow-x-hidden">

<!-- ================================================================== -->
<!-- NAVBAR =========================================================== -->
<!-- ================================================================== -->
<header x-bind:class="scrolled ? 'bg-white/85 backdrop-blur-xl shadow-sm border-b border-slate-200/60' : 'bg-transparent border-transparent'"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500 border-b">
    <div class="container-landing flex h-[72px] items-center justify-between">
        <a href="/" class="flex items-center gap-2.5" aria-label="HRIS Gampang">
            <div class="flex h-[34px] w-[34px] items-center justify-center rounded-[10px] bg-gradient-to-br from-primary-500 to-primary-700 shadow-md shadow-primary-500/20">
                <svg class="h-[18px] w-[18px] text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span class="font-display text-lg font-bold text-slate-900 tracking-tight">HRIS&nbsp;<span class="text-primary-600">Gampang</span></span>
        </a>

        <nav class="hidden items-center lg:flex" aria-label="Main">
            <a href="#features" class="btn-ghost">Fitur</a>
            <a href="#pricing" class="btn-ghost">Harga</a>
            <a href="#testimonials" class="btn-ghost">Testimoni</a>
            <a href="#faq" class="btn-ghost">FAQ</a>
            <a href="#contact" class="btn-ghost">Kontak</a>
        </nav>

        <div class="hidden items-center gap-2 lg:flex">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary text-sm px-5 py-2.5">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary text-sm px-5 py-2.5">Daftar Gratis</a>
                @endif
            @endauth
        </div>

        <button @click="mobileOpen = !mobileOpen" class="inline-flex items-center justify-center rounded-[12px] border border-slate-200 bg-white p-2.5 shadow-sm lg:hidden" aria-label="Menu">
            <svg x-show="!mobileOpen" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobileOpen" x-cloak class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         class="border-t border-slate-200 bg-white/95 backdrop-blur-xl lg:hidden">
        <div class="px-6 py-5 space-y-1">
            <a href="#features" @click="mobileOpen = false" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Fitur</a>
            <a href="#pricing" @click="mobileOpen = false" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Harga</a>
            <a href="#testimonials" @click="mobileOpen = false" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Testimoni</a>
            <a href="#faq" @click="mobileOpen = false" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">FAQ</a>
            <a href="#contact" @click="mobileOpen = false" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Kontak</a>
        </div>
        <div class="border-t border-slate-200 px-6 py-4 space-y-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary w-full justify-center text-sm py-3">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-secondary w-full justify-center text-sm py-3">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary w-full justify-center text-sm py-3">Daftar Gratis</a>
                @endif
            @endauth
        </div>
    </div>
</header>

<!-- ================================================================== -->
<!-- 1. HERO =========================================================== -->
<!-- ================================================================== -->
<section class="relative min-h-[92vh] flex items-center overflow-hidden bg-gradient-to-b from-slate-50 via-primary-50/20 to-white pt-24">
    <div class="pointer-events-none absolute inset-0 bg-hero-glow" aria-hidden="true"></div>
    <div class="absolute left-1/2 top-0 -translate-x-1/2 w-full max-w-[1000px] h-[600px] bg-gradient-radial from-primary-400/8 to-transparent blur-[100px]" aria-hidden="true"></div>
    <div class="absolute -left-40 top-1/4 h-[500px] w-[500px] rounded-full bg-primary-300/8 blur-[120px]" aria-hidden="true"></div>
    <div class="absolute -right-40 bottom-1/4 h-[400px] w-[400px] rounded-full bg-primary-400/6 blur-[100px]" aria-hidden="true"></div>

    <div class="container-landing relative z-10 w-full py-20 md:py-28">
        <div class="mx-auto max-w-[880px] text-center">
            <div class="mb-8 animate-fade-down inline-flex items-center gap-2 rounded-full border border-primary-200/50 bg-primary-50/80 px-[14px] py-[6px] text-[11px] font-semibold uppercase tracking-[0.12em] text-primary-700 shadow-sm">
                <span class="tag-dot"></span>
                Solusi HR #1 di Indonesia — <span class="text-primary-500">Gratis Selamanya</span>
            </div>

            <h1 class="heading-xl mx-auto max-w-[800px]">
                Kelola Seluruh<br>
                <span class="text-gradient">Data Kepegawaian</span>
                <br>dalam Satu Platform
            </h1>

            <p class="body-lg mx-auto mt-6 max-w-[640px] text-balance">
                HRIS Gampang membantu Anda mengelola data pegawai, cuti, absensi, dan penggajian tanpa ribet.
                Cukup satu dashboard untuk semua kebutuhan HR bisnis Anda.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('register') }}" class="btn-primary w-full sm:w-auto text-[15px] px-8 py-4">
                    Mulai Gratis
                    <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="#demo" class="btn-secondary w-full sm:w-auto text-[15px] px-8 py-4">
                    <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Lihat Demo
                </a>
            </div>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-sm text-slate-400">
                <div class="flex -space-x-2.5">
                    <img class="h-9 w-9 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name=Andi&background=2b8fff&color=fff&size=36" alt="User">
                    <img class="h-9 w-9 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name=Sari&background=53b0ff&color=fff&size=36" alt="User">
                    <img class="h-9 w-9 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name=Budi&background=0d5be1&color=fff&size=36" alt="User">
                    <img class="h-9 w-9 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name=Dewi&background=8eccff&color=fff&size=36" alt="User">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-primary-100 text-[11px] font-bold text-primary-700">500+</span>
                </div>
                <span class="text-slate-500"><strong class="font-semibold text-slate-900">500+</strong> bisnis telah bergabung</span>
                <span class="hidden sm:inline text-slate-300">·</span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    <span class="text-slate-500">Gratis selamanya, tanpa kartu kredit</span>
                </span>
            </div>
        </div>

        <div class="mx-auto mt-16 max-w-[960px] animate-fade-up">
            <div class="relative">
                <div class="absolute -inset-2 rounded-[20px] bg-gradient-to-r from-primary-500/15 via-primary-400/5 to-primary-500/15 blur-2xl" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-[16px] border border-slate-200/80 bg-white shadow-2xl shadow-slate-200/50">
                    <div class="flex items-center gap-1.5 border-b border-slate-200 bg-slate-50/80 px-5 py-3.5">
                        <span class="h-[10px] w-[10px] rounded-full bg-red-400/80"></span>
                        <span class="h-[10px] w-[10px] rounded-full bg-yellow-400/80"></span>
                        <span class="h-[10px] w-[10px] rounded-full bg-emerald-400/80"></span>
                        <span class="ml-3 text-[12px] font-medium text-slate-400/80">hrisgampang.app/dashboard</span>
                    </div>
                    <div class="grid grid-cols-[1fr_280px] gap-0">
                        <div class="p-6 space-y-4 border-r border-slate-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-primary-100 flex items-center justify-center"><span class="text-xs font-bold text-primary-600">HG</span></div>
                                    <div><div class="h-3 w-20 rounded bg-slate-200"></div><div class="h-2 w-14 rounded bg-slate-100 mt-1"></div></div>
                                </div>
                                <div class="h-6 w-16 rounded-lg bg-primary-50 border border-primary-200"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl bg-primary-50/70 border border-primary-100/50 p-3 space-y-2">
                                    <div class="h-2 w-10 rounded bg-primary-200"></div>
                                    <div class="h-6 w-8 rounded bg-primary-500"></div>
                                    <div class="h-2 w-12 rounded bg-primary-200/50"></div>
                                </div>
                                <div class="rounded-xl bg-slate-100 p-3 space-y-2">
                                    <div class="h-2 w-10 rounded bg-slate-300"></div>
                                    <div class="h-6 w-8 rounded bg-slate-400"></div>
                                    <div class="h-2 w-12 rounded bg-slate-200/50"></div>
                                </div>
                                <div class="rounded-xl bg-slate-100 p-3 space-y-2">
                                    <div class="h-2 w-10 rounded bg-slate-300"></div>
                                    <div class="h-6 w-8 rounded bg-slate-400"></div>
                                    <div class="h-2 w-12 rounded bg-slate-200/50"></div>
                                </div>
                            </div>
                            <div class="rounded-xl bg-slate-100 p-3 space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="inline-block h-[6px] w-[6px] rounded-full bg-emerald-400"></span>
                                    <div class="h-2 flex-1 rounded bg-slate-300"></div>
                                    <div class="h-2 w-16 rounded bg-slate-300"></div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-block h-[6px] w-[6px] rounded-full bg-amber-400"></span>
                                    <div class="h-2 flex-1 rounded bg-slate-300"></div>
                                    <div class="h-2 w-16 rounded bg-slate-300"></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-4 bg-slate-50/30">
                            <div class="h-2 w-16 rounded bg-slate-300"></div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center"><div class="h-[6px] w-[6px] rounded-full bg-primary-500"></div></div>
                                    <div class="h-2 flex-1 rounded bg-primary-200"></div>
                                    <div class="h-2 w-8 rounded bg-primary-200"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center"><div class="h-[6px] w-[6px] rounded-full bg-slate-400"></div></div>
                                    <div class="h-2 flex-1 rounded bg-slate-300"></div>
                                    <div class="h-2 w-8 rounded bg-slate-300"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center"><div class="h-[6px] w-[6px] rounded-full bg-slate-400"></div></div>
                                    <div class="h-2 flex-1 rounded bg-slate-300"></div>
                                    <div class="h-2 w-8 rounded bg-slate-300"></div>
                                </div>
                            </div>
                            <div class="h-2 w-16 rounded bg-slate-300"></div>
                            <div class="rounded-xl bg-slate-100 p-3 space-y-2">
                                <div class="h-2 w-full rounded bg-slate-300"></div>
                                <div class="h-2 w-3/4 rounded bg-slate-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- LOGO CLIENTS ===================================================== -->
<!-- ================================================================== -->
<section class="border-y border-slate-200/60 bg-slate-50/50 py-12">
    <div class="container-landing">
        <p class="mb-8 text-center text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-400">Dipercaya oleh tim HR dari berbagai perusahaan</p>
        <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6">
            <div class="flex items-center gap-3"><div class="h-7 w-7 rounded-lg bg-primary-100"></div><span class="text-sm font-bold text-slate-400">TechCorp</span></div>
            <div class="flex items-center gap-3"><div class="h-7 w-7 rounded-lg bg-emerald-100"></div><span class="text-sm font-bold text-slate-400">BinaUsaha</span></div>
            <div class="flex items-center gap-3"><div class="h-7 w-7 rounded-lg bg-violet-100"></div><span class="text-sm font-bold text-slate-400">KaryaMandiri</span></div>
            <div class="flex items-center gap-3"><div class="h-7 w-7 rounded-lg bg-amber-100"></div><span class="text-sm font-bold text-slate-400">SejahteraGroup</span></div>
            <div class="flex items-center gap-3"><div class="h-7 w-7 rounded-lg bg-rose-100"></div><span class="text-sm font-bold text-slate-400">SolusiPrima</span></div>
            <div class="flex items-center gap-3"><div class="h-7 w-7 rounded-lg bg-cyan-100"></div><span class="text-sm font-bold text-slate-400">Nusantara</span></div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 2. FEATURES ====================================================== -->
<!-- ================================================================== -->
<section id="features" class="section-pad relative overflow-hidden">
    <div class="absolute inset-0 bg-section-glow" aria-hidden="true"></div>
    <div class="container-landing relative z-10">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-6">Fitur Unggulan</span>
            <h2 class="heading-lg">Semua yang Anda Butuhkan<br>untuk <span class="text-gradient">Manajemen HR</span></h2>
            <p class="body-lg mt-4">Platform all-in-one yang dirancang khusus untuk memudahkan administrasi kepegawaian bisnis Anda, dari skala kecil hingga enterprise.</p>
        </div>

        <div class="mt-16 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 animate-stagger">
            <div class="card card-hover group">
                <div class="card-icon bg-gradient-to-br from-primary-500 to-primary-600 shadow-primary-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
                <h3 class="heading-md">Manajemen Pegawai</h3>
                <p class="body-md mt-3">Database pegawai terpusat dengan pencarian cepat, filter multi-kriteria, dan profil lengkap setiap karyawan.</p>
                <div class="mt-6 flex items-center gap-1 text-sm font-semibold text-primary-600 opacity-0 translate-x-[-8px] transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
                    <span>Selengkapnya</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="card-icon bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-emerald-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="heading-md">Manajemen Cuti</h3>
                <p class="body-md mt-2">Ajukan dan setujui cuti dalam hitungan detik. Sistem menghitung kuota tahunan otomatis — tidak ada lagi pengajuan hilang.</p>
                <div class="mt-6 flex items-center gap-1 text-sm font-semibold text-emerald-600 opacity-0 translate-y-[-8px] transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                    <span>Selengkapnya</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="card-icon bg-gradient-to-br from-violet-500 to-violet-600 shadow-violet-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="heading-md">Laporan Kehadiran</h3>
                <p class="body-md mt-2">Rekap kehadiran akurat dengan filter tanggal, departemen, dan status. Ekspor ke Excel atau PDF dalam satu klik.</p>
                <div class="mt-6 flex items-center gap-1 text-sm font-semibold text-violet-600 opacity-0 translate-y-[-8px] transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                    <span>Selengkapnya</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="card-icon bg-gradient-to-br from-amber-500 to-amber-600 shadow-amber-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="heading-md">Penggajian Otomatis</h3>
                <p class="body-md mt-2">Kalkulasi gaji, tunjangan, dan potongan secara otomatis. Pegawai bisa lihat & download slip gaji masing-masing.</p>
                <div class="mt-6 flex items-center gap-1 text-sm font-semibold text-amber-600 opacity-0 translate-y-[-8px] transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                    <span>Selengkapnya</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="card-icon bg-gradient-to-br from-rose-500 to-rose-600 shadow-rose-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="heading-md">Dashboard Analitik</h3>
                <p class="body-md mt-2">Pantau kondisi kepegawaian secara real-time: jumlah pegawai aktif, cuti hari ini, dan rekap payroll dalam satu layar.</p>
                <div class="mt-6 flex items-center gap-1 text-sm font-semibold text-rose-600 opacity-0 translate-y-[-8px] transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                    <span>Selengkapnya</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="card-icon bg-gradient-to-br from-cyan-500 to-cyan-600 shadow-cyan-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="heading-md">Akses Berbasis Peran</h3>
                <p class="body-md mt-2">Tiga level akses: Admin HR, Atasan, dan Pegawai. Data sensitif seperti gaji hanya bisa diakses sesuai peran.</p>
                <div class="mt-6 flex items-center gap-1 text-sm font-semibold text-cyan-600 opacity-0 translate-y-[-8px] transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                    <span>Selengkapnya</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 3. HOW IT WORKS ================================================== -->
<!-- ================================================================== -->
<section class="section-pad bg-white border-t border-slate-200/60">
    <div class="container-landing">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-4">Cara Kerja</span>
            <h2 class="heading-lg">Mulai dalam <span class="text-gradient">3 Langkah Mudah</span></h2>
            <p class="body-lg mt-4">Tidak perlu installasi rumit atau training panjang. Langsung pakai dalam hitungan menit.</p>
        </div>

        <div class="mt-16 grid gap-8 md:grid-cols-3">
            <div class="relative text-center">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-[18px] bg-primary-100 shadow-sm">
                    <span class="font-display text-2xl font-extrabold text-primary-600">1</span>
                </div>
                <h3 class="heading-md">Daftar Akun</h3>
                <p class="body-md mt-2">Buat akun gratis dengan email. Tidak perlu kartu kredit. Proses registrasi hanya 1 menit.</p>
            </div>

            <div class="relative text-center">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-[18px] bg-primary-50 shadow-sm">
                    <span class="font-display text-2xl font-extrabold text-primary-600">2</span>
                </div>
                <div class="hidden md:block absolute top-8 left-[-40%] w-[80%] h-px border-t-2 border-dashed border-primary-200"></div>
                <h3 class="heading-md">Input Data Pegawai</h3>
                <p class="body-md mt-2">Tambah data karyawan, atur departemen & jabatan. Import dari Excel juga tersedia.</p>
            </div>

            <div class="relative text-center">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-[18px] bg-primary-50 shadow-sm">
                    <span class="font-display text-2xl font-extrabold text-primary-600">3</span>
                </div>
                <div class="hidden md:block absolute top-1 left-[-40%] w-[80%] h-px border-t-2 border-dashed border-primary-200"></div>
                <h3 class="heading-md">Kelola & Otomatiskan</h3>
                <p class="body-md mt-2">Sistem siap digunakan. Kelola cuti, absensi, dan payroll dengan proses otomatis penuh.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 4. STATISTICS ==================================================== -->
<!-- ================================================================== -->
<section class="section-pad relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle at 25% 25%, white 1px, transparent 1px); background-size: 48px 48px;" aria-hidden="true"></div>
    <div class="absolute top-0 right-0 h-[500px] w-[500px] translate-x-1/3 -translate-y-1/3 rounded-full bg-primary-500/5 blur-[120px]" aria-hidden="true"></div>
    <div class="absolute bottom-0 left-0 h-[400px] w-[400px] -translate-x-1/3 translate-y-1/3 rounded-full bg-primary-400/5 blur-[100px]" aria-hidden="true"></div>

    <div class="container-landing relative z-10">
        <div class="mx-auto max-w-[640px] text-center">
            <h2 class="heading-lg text-white">Angka yang Berbicara</h2>
            <p class="mt-4 body-lg text-white/60">Dampak nyata yang telah kami berikan untuk bisnis di Indonesia</p>
        </div>

        <div class="mt-14 grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
            <div class="rounded-[16px] border border-white/[0.06] bg-white/[0.04] p-8 text-center backdrop-blur-sm transition-all duration-500 hover:bg-white/[0.08] hover:-translate-y-1">
                <div class="font-display text-[2.5rem] font-extrabold leading-none text-white md:text-[3rem]">
                    <span x-data="{ n: 0 }" x-init="setInterval(() => { if(n < 500) n++ }, 8)" x-text="n">500</span><span class="text-primary-400">+</span>
                </div>
                <div class="mt-2 text-sm font-medium text-white/50">Bisnis Terdaftar</div>
            </div>
            <div class="rounded-[16px] border border-white/[0.06] bg-white/[0.04] p-8 text-center backdrop-blur-sm transition-all duration-500 hover:bg-white/[0.08] hover:-translate-y-1">
                <div class="font-display text-[2.5rem] font-extrabold leading-none text-white sm:text-[3rem]">
                    <span>5</span><span class="text-primary-400">K</span><span class="text-white">+</span>
                </div>
                <div class="mt-2 text-sm font-medium text-white/50">Karyawan Terkelola</div>
            </div>
            <div class="rounded-[16px] border border-white/[0.06] bg-white/[0.04] p-8 text-center backdrop-blur-sm transition-all duration-500 hover:bg-white/[0.08] hover:-translate-y-1">
                <div class="font-display text-[2.5rem] font-extrabold leading-none text-white sm:text-[3rem]">
                    <span>98</span><span class="text-primary-400">%</span>
                </div>
                <div class="mt-2 text-sm font-medium text-white/50">Kepuasan Pelanggan</div>
            </div>
            <div class="rounded-[16px] border border-white/[0.06] bg-white/[0.04] p-8 text-center backdrop-blur-sm transition-all duration-500 hover:bg-white/[0.08] hover:-translate-y-1">
                <div class="font-display text-[2.5rem] font-extrabold leading-none text-white sm:text-[3rem]">
                    <span>10</span><span class="text-primary-400">K</span><span class="text-primary">+</span>
                </div>
                <div class="mt-2 text-sm font-medium text-white/50">Slip Gaji Terbit</div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 5. PRICING ======================================================= -->
<!-- ================================================================== -->
<section id="pricing" class="section-pad bg-slate-50">
    <div class="container-landing">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-4">Harga</span>
            <h2 class="heading-lg">Harga Sederhana,<br><span class="text-gradient">Tanpa Ribet</span></h2>
            <p class="body-lg mt-4">Mulai gratis selamanya. Tingkatkan kapan pun sesuai kebutuhan bisnis Anda.</p>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-3">
            <div class="card card-hover text-center">
                <h3 class="heading-md">Basic</h3>
                <p class="body-md mt-1">Untuk tim kecil yang baru mulai</p>
                <div class="mt-6 mb-8 h-px bg-slate-200"></div>
                <div class="font-display text-[3.5rem] font-extrabold tracking-tight text-slate-900">Gratis</div>
                <ul class="mt-8 space-y-4 text-left px-4">
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Hingga <strong class="text-slate-900">10 pegawai</strong>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Manajemen pegawai & cuti
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-400">
                        <svg class="h-5 w-5 shrink-0 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Laporan kehadiran
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-400">
                        <svg class="h-5 w-5 shrink-0 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Payroll otomatis
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn-secondary mt-8 w-full justify-center">Mulai Gratis</a>
            </div>

            <div class="relative card shadow-xl shadow-primary-500/5 border-2 border-primary-500 translate-y-[-8px]">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-primary-600 px-5 py-1.5 text-[11px] font-bold text-white shadow-lg tracking-wide uppercase">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Terpopuler
                    </span>
                </div>
                <div class="text-center pt-2">
                    <h3 class="heading-md">Pro</h3>
                    <p class="body-md mt-1">Solusi lengkap bisnis berkembang</p>
                    <div class="mt-6 mb-6 h-px bg-primary-200/50"></div>
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="font-display text-[3.5rem] font-extrabold tracking-tight text-slate-900">Rp99</span>
                        <span class="text-sm text-slate-500">/bulan</span>
                    </div>
                    <ul class="mt-8 space-y-4 text-left px-4">
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Hingga <strong class="text-slate-900">50 pegawai</strong>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Semua fitur Basic
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Laporan kehadiran + ekspor Excel/PDF
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Payroll otomatis + slip gaji
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Komponen gaji fleksibel
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-primary mt-8 w-full justify-center">Mulai Sekarang</a>
                </div>
            </div>

            <div class="card card-hover text-center">
                <h3 class="heading-md">Enterprise</h3>
                <p class="body-md mt-1">Untuk perusahaan dengan skala besar</p>
                <div class="mt-6 mb-6 h-px bg-slate-200"></div>
                <div class="font-display text-[2.75rem] font-extrabold tracking-tight text-slate-900">Custom</div>
                <ul class="mt-8 space-y-4 text-left px-4">
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Pegawai <strong class="text-slate-900">tidak terbatas</strong>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Semua fitur Pro
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Kustomisasi fitur sesuai kebutuhan
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Support prioritas 24/7
                    </li>
                </ul>
                <a href="#contact" class="btn-secondary mt-8 w-full justify-center">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 6. TESTIMONIALS ================================================== -->
<!-- ================================================================== -->
<section id="testimonials" class="section-pad relative overflow-hidden bg-white">
    <div class="container-landing">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-4">Testimoni</span>
            <h2 class="heading-lg">Apa Kata <span class="text-gradient">Mereka</span></h2>
            <p class="body-lg mt-4">Dengarkan pengalaman bisnis yang telah merapikan HR mereka dengan HRIS Gampang.</p>
        </div>

        <div class="relative mt-14 overflow-hidden" x-data="{}">
            <div class="flex gap-6 w-max animate-marquee hover:paused">
                <template x-for="i in 6" :key="i">
                    <div class="w-[380px] shrink-0 rounded-[16px] border border-slate-200/70 bg-white p-7 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-1 mb-4">
                            <template x-for="s in 5">
                                <svg class="h-[14px] w-[14px] text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </template>
                        </div>
                        <p class="text-sm leading-relaxed text-slate-600 line-clamp-4" x-text="testimonials[i-1].text"></p>
                        <div class="mt-5 flex items-center gap-3 pt-5 border-t border-slate-200/50">
                            <img class="h-10 w-10 rounded-full" x-bind:src="testimonials[i-1].avatar" :alt="testimonials[i-1].name">
                            <div>
                                <div class="text-sm font-semibold text-slate-900" x-text="testimonials[i-1].name"></div>
                                <div class="text-xs text-slate-500" x-text="testimonials[i-1].role"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 7. PORTFOLIO / USE CASE ========================================= -->
<!-- ================================================================== -->
<section id="portfolio" class="section-pad bg-slate-50">
    <div class="container-landing">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-4">Portofolio</span>
            <h2 class="heading-lg">Cocok untuk<br><span class="text-gradient">Berbagai Sektor</span></h2>
            <p class="body-lg mt-4">HRIS Gampang telah digunakan oleh berbagai jenis bisnis, dari startup hingga enterprise.</p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="card card-hover overflow-hidden p-0">
                <div class="aspect-[16/10] bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center">
                    <svg class="h-20 w-20 text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="p-7">
                    <h3 class="heading-md">Startup & UKM</h3>
                    <p class="body-md mt-2">Kelola tim 5-50 orang dengan mudah tanpa perlu HR department khusus. Semua cukup dari satu dashboard.</p>
                </div>
            </div>

            <div class="card card-hover overflow-hidden p-0">
                <div class="aspect-[4/10] bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">
                    <svg class="h-20 w-20 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div class="p-7">
                    <h3 class="heading-md">Perusahaan Retail</h3>
                    <p class="body-md mt-2">Kelola shift, absensi, dan payroll karyawan toko dari satu dashboard pusat.</p>
                </div>
            </div>

            <div class="card card-hover overflow-hidden p-0">
                <div class="aspect-[4/10] bg-gradient-to-br from-violet-100 to-violet-50 flex items-center justify-center">
                    <svg class="h-20 w-20 text-violet-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="p-7">
                    <h3 class="heading-md">Lembaga Pendidikan</h3>
                    <p class="body-md mt-2">Sekolah dan lembaga kursus kelola data guru, staf administrasi, dan payroll dengan rapi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 8. FAQ ========================================================== -->
<!-- ================================================================== -->
<section id="faq" class="section-pad bg-white">
    <div class="container-landing max-w-[768px]">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-4">FAQ</span>
            <h2 class="heading-lg">Pertanyaan <span class="text-gradient">Umum</span></h2>
            <p class="body-lg mt-4">Temukan jawaban cepat seputar HRIS Gampang.</p>
        </div>

        <div class="mt-14 space-y-3" x-data="{ active: null }">
            <template x-for="(faq, i) in faqs" :key="i">
                <div class="rounded-[16px] border border-slate-200/60 bg-slate-50/50 transition-all duration-300" :class="{'border-primary-300/50 bg-primary-50/40 shadow-sm': active === i}">
                    <button @click="active = active === i ? null : i" class="flex w-full items-center justify-between px-6 md:px-8 py-5 text-left" :aria-expanded="active === i">
                        <span class="text-sm font-semibold text-slate-900 pr-4" x-text="faq.q"></span>
                        <svg class="h-5 w-5 shrink-0 text-slate-400 transition-all duration-300" :class="{'rotate-180 text-primary-500': active === i}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === i" x-collapse.duration.300ms>
                        <div class="border-t border-slate-200 px-5 md:px-8 py-5">
                            <p class="text-sm leading-relaxed text-slate-600" x-text="faq.a"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 9. BLOG ========================================================= -->
<!-- ================================================================== -->
<section id="blog" class="section-pad bg-slate-50">
    <div class="container-landing">
        <div class="mx-auto max-w-[640px] text-center">
            <span class="tag mb-4">Blog</span>
            <h2 class="heading-lg">Artikel & <span class="text-gradient">Wawasan HR</span></h2>
            <p class="body-lg mt-4">Tips, panduan, dan berita terbaru seputar dunia HR dan pengelolaan kepegawaian.</p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <article class="card card-hover overflow-hidden p-0">
                <div class="aspect-[16/9] bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center">
                    <svg class="h-12 w-12 text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="p-6">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-primary-600">HR Tips</span>
                    <h3 class="mt-2 heading-md group-hover:text-primary-600 transition-colors">5 Cara Efektif Kelola Cuti Karyawan</h3>
                    <p class="body-md mt-2 line-clamp-2">Pelajari cara terbaik mengelola pengajuan cuti tanpa mengganggu produktivitas tim.</p>
                    <a href="#" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-primary-600 transition-all hover:gap-2">
                        Baca selengkapnya
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="card card-hover overflow-hidden p-0">
                <div class="aspect-[16/9] bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">
                    <svg class="h-12 w-12 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="p-6">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-emerald-600">Payroll</span>
                    <h3 class="mt-2 heading-md">Panduan Hitung Gaji Karyawan Bulanan</h3>
                    <p class="body-md mt-2 line-clamp-2">Langkah mudah menghitung gaji lengkap dengan tunjangan dan potongan.</p>
                    <a href="#" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 transition-all hover:gap-2">
                        Baca selengkapnya
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="card card-hover overflow-hidden p-0">
                <div class="aspect-[16/9] bg-gradient-to-br from-violet-100 to-violet-50 flex items-center justify-center">
                    <svg class="h-12 w-12 text-violet-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="p-6">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-violet-600">Teknologi</span>
                    <h3 class="mt-2 heading-md">Mengapa HRIS Penting untuk Bisnis 2026</h3>
                    <p class="body-md mt-2 line-clamp-2">Transformasi digital HR bukan lagi pilihan — ini kebutuhan untuk tetap kompetitif.</p>
                    <a href="#" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-violet-600 transition-all hover:gap-2">
                        Baca selengkapnya
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 10. CTA / CONTACT ============================================== -->
<!-- ================================================================== -->
<section id="contact" class="section-pad relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 75% 25%, white 1px, transparent 1px); background-size: 48px 48px;" aria-hidden="true"></div>
    <div class="absolute left-1/2 top-1/2 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary-500/8 blur-[120px]" aria-hidden="true"></div>

    <div class="container-landing relative z-10 text-center">
        <h2 class="heading-lg text-white">
            Siap <span class="text-primary-300">Menyderhanakan</span><br>HR Anda?
        </h2>
        <p class="body-lg mx-auto mt-4 max-w-[560px] text-white/60">
            Bergabung dengan 500+ bisnis yang telah merapikan manajemen kepegawaian mereka. Gratis selamanya untuk tim kecil.
        </p>

        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2.5 rounded-2xl bg-white px-8 py-4 text-[15px] font-semibold text-primary-700 shadow-lg shadow-white/10 transition-all duration-300 hover:bg-primary-50 hover:shadow-xl hover:-translate-y-0.5">
                Mulai Gratis Sekarang
                <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="mailto:hello@hrisgampang.app" class="inline-flex items-center justify-center gap-2.5 rounded-2xl border border-white/10 bg-white/5 px-8 py-4 text-sm font-semibold text-white shadow-sm backdrop-blur-sm transition-all duration-300 hover:bg-white/10">
                <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                hello@hrisgampang.app
            </a>
        </div>
    </div>
</section>

<!-- ================================================================== -->
<!-- 11. FOOTER ====================================================== -->
<!-- ================================================================== -->
<footer class="bg-slate-950 border-t border-slate-800/50">
    <div class="container-landing py-16 md:py-20">
        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="flex h-[34px] w-[34px] items-center justify-center rounded-[10px] bg-gradient-to-br from-primary-500 to-primary-700 shadow-md">
                        <svg class="h-[18px] w-[18px] text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="font-display text-lg font-bold text-white tracking-tight">HRIS&nbsp;<span class="text-primary-400">Gampang</span></span>
                </a>
                <p class="mt-4 text-sm leading-relaxed text-slate-400 max-w-xs">Sistem manajemen kepegawaian paling sederhana untuk bisnis Indonesia. Kelola karyawan, cuti, absensi, dan gaji dalam satu platform.</p>
                <div class="mt-6 flex gap-3">
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-slate-800 text-slate-400 transition-colors hover:bg-primary-600 hover:text-white" aria-label="Instagram">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-slate-800 text-slate-400 transition-colors hover:bg-primary-600 hover:text-white" aria-label="Twitter">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-slate-800 text-slate-400 transition-colors hover:bg-primary-600 hover:text-white" aria-label="LinkedIn">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white/80">Fitur</h4>
                <ul class="mt-5 space-y-3">
                    <li><a href="#features" class="text-sm text-slate-400 transition-colors hover:text-white">Manajemen Pegawai</a></li>
                    <li><a href="#features" class="text-sm text-slate-400 transition-colors hover:text-white">Pengajuan Cuti</a></li>
                    <li><a href="#features" class="text-sm text-slate-400 transition-colors hover:text-white">Laporan Kehadiran</a></li>
                    <li><a href="#features" class="text-sm text-slate-400 transition-colors hover:text-white">Penggajian Otomatis</a></li>
                    <li><a href="#features" class="text-sm text-slate-400 transition-colors hover:text-white">Dashboard Analitik</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white/80">Perusahaan</h4>
                <ul class="mt-5 space-y-3">
                    <li><a href="#" class="text-sm text-slate-400 transition-colors hover:text-white">Tentang Kami</a></li>
                    <li><a href="{{ route('register') }}" class="text-sm text-slate-400 transition-colors hover:text-white">Daftar</a></li>
                    <li><a href="{{ route('login') }}" class="text-sm text-slate-400 transition-colors hover:text-white">Masuk</a></li>
                    <li><a href="#pricing" class="text-sm text-slate-400 transition-colors hover:text-white">Harga</a></li>
                    <li><a href="#contact" class="text-sm text-slate-400 transition-colors hover:text-white">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white/80">Dukungan</h4>
                <ul class="mt-5 space-y-3">
                    <li><a href="mailto:hello@hrisgampang.app" class="text-sm text-slate-400 transition-colors hover:text-white">hello@hrisgampang.app</a></li>
                    <li><a href="#" class="text-sm text-slate-400 transition-colors hover:text-white">Dokumentasi</a></li>
                    <li><a href="#faq" class="text-sm text-slate-400 transition-colors hover:text-white">FAQ</a></li>
                    <li><a href="#" class="text-sm text-slate-400 transition-colors hover:text-white">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-sm text-slate-400 transition-colors hover:text-white">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 sm:flex-row">
            <p class="text-xs text-slate-500">&copy; {{ date('Y') }} HRIS Gampang. All rights reserved.</p>
        </div>
    </div>
</footer>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            faqs: [
                { q: 'Apa itu HRIS Gampang?', a: 'HRIS Gampang adalah platform manajemen kepegawaian berbasis web yang membantu bisnis mengelola data karyawan, cuti, absensi, dan penggajian dalam satu sistem terpadu. Dirancang khusus untuk kemudahan penggunaan tanpa perlu training panjang.' },
                { q: 'Apakah benar-benar gratis?', a: 'Ya! Paket Basic gratis selamanya untuk hingga 10 pegawai dengan fitur manajemen pegawai dan cuti lengkap. Tidak perlu kartu kredit, tidak ada masa percobaan berbatas.' },
                { q: 'Bagaimana cara mendaftar?', a: 'Cukup klik "Daftar Gratis", isi email dan password, lalu akun Anda langsung aktif. Prosesnya tidak sampai 2 menit. Anda langsung bisa mulai menambahkan data pegawai.' },
                { q: 'Apakah data saya aman?', a: 'Keamanan adalah prioritas kami. Data disimpan dengan enkripsi, akses berbasis peran (role-based access control), dan semua koneksi menggunakan HTTPS. Kami juga melakukan backup database secara rutin setiap hari.' },
                { q: 'Bisa ekspor laporan ke Excel?', a: 'Tentu. Semua laporan kehadiran dan payroll bisa diekspor ke format Excel/CSV dalam satu klik. Slip gaji juga bisa diunduh dalam format PDF siap cetak.' },
                { q: 'Apakah bisa custom komponen gaji?', a: 'Sangat bisa. Anda bisa mengatur sendiri komponen gaji seperti gaji pokok, tunjangan transport, makan, kesehatan, potongan terlambat, dan lain-lain sesuai kebijakan perusahaan.' },
            ],
            testimonials: [
                { text: '"Setelah pindah dari Excel ke HRIS Gampang, proses payroll yang dulu makan waktu 3 hari kini selesai dalam 1 jam. Game changer banget untuk bisnis saya!"', name: 'Andi Pratama', role: 'Owner, TechCorp Indonesia', avatar: 'https://ui-avatars.com/api/?name=Andi+Pratama&background=2b8fff&color=fff&size=40' },
                { text: '"Saya suka sistem cuti yang otomatis — tidak ada lagi pengajuan cuti yang terlewat. Kuota cuti terhitung otomatis, tidak perlu manual."', name: 'Sari Dewi', role: 'HR Manager, BinaUsaha Group', avatar: 'https://ui-avatars.com/api/?name=Sari+Dewi&background=1470f5&color=fff&size=40' },
                { text: '"Karyawan bisa akses slip gaji sendiri kapan saja. HR tidak dibanjiri pertanyaan soal gaji setiap akhir bulan. Efisien sekali."', name: 'Budi Santoso', role: 'Finance, KaryaMandiri', avatar: 'https://ui-avatars.com/api/?name=Budi+Santoso&background=0d5be1&color=fff&size=40' },
                { text: '"UI-nya bersih, enak dilihat, dan staff saya yang kurang melek teknologi pun bisa pakai tanpa training khusus. Recommended!"', name: 'Dewi Lestari', role: 'Owner, SejahteraGroup', avatar: 'https://ui-avatars.com/api/?name=Dewi+Lestari&background=53b0ff&color=fff&size=40' },
                { text: '"Dengan 50+ karyawan, HRIS Gampang membantu kami melacak kehadiran dengan sangat akurat. Fitur ekspor laporan cepat dan akurat."', name: 'Rudi Hermawan', role: 'Operational Manager, SolusiPrima', avatar: 'https://ui-avatars.com/api/?name=Rudi+Hermawan&background=8eccff&color=fff&size=40' },
                { text: '"Fitur role-based access-nya tepat — admin full akses, manager hanya approval, dan karyawan untuk data diri sendiri. Privasi data terjaga."', name: 'Fitri Ayu', role: 'IT Manager, MajuTeknologi', avatar: 'https://ui-avatars.com/api/?name=Fitri+Ayu&background=114ab6&color=fff&size=40' },
            ],
        }));
    });
</script>

<style>
    [x-cloak] { display: none !important; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-4 { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
    .paused { animation-play-state: paused; }
    .w-max { width: max-content; }
</style>
</body>
</html>