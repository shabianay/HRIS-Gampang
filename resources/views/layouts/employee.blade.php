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
    @stack('styles')
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        {{-- Desktop Sidebar --}}
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-slate-200 shadow-sm">
                <div class="flex items-center gap-2.5 px-5 pt-5 pb-4 border-b border-slate-100">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg shadow-primary-500/20">
                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-display text-sm font-bold text-slate-900 tracking-tight">HRIS <span class="text-primary-600">Gampang</span></span>
                </div>
                <div class="flex-1 flex flex-col py-4 overflow-y-auto scrollbar-hide">
                    <nav class="flex-1 px-3 space-y-0.5">
                        <a href="{{ route('employee.dashboard') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 transition-all duration-200 {{ request()->routeIs('employee.dashboard') ? 'text-primary-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('employee.attendances.index') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.attendances.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 transition-all duration-200 {{ request()->routeIs('employee.attendances.*') ? 'text-primary-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Kehadiran</span>
                        </a>
                        <a href="{{ route('employee.leave-requests.index') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.leave-requests.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 transition-all duration-200 {{ request()->routeIs('employee.leave-requests.*') ? 'text-primary-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Cuti</span>
                        </a>
                        <a href="{{ route('employee.payrolls.index') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.payrolls.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 transition-all duration-200 {{ request()->routeIs('employee.payrolls.*') ? 'text-primary-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Slip Gaji</span>
                        </a>
                        <div class="pt-5 mt-4 border-t border-slate-100">
                            <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">Akun</p>
                            <div class="mt-2 space-y-0.5">
                                <a href="{{ route('employee.profile.edit') }}"
                                   class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.profile.edit') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <svg class="h-5 w-5 flex-shrink-0 transition-all duration-200 {{ request()->routeIs('employee.profile.edit') ? 'text-primary-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Profil</span>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Mobile Sidebar Overlay --}}
        <div class="fixed inset-0 flex z-40 lg:hidden" x-show="sidebarOpen" x-cloak>
            <div class="fixed inset-0" @click="sidebarOpen = false">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            </div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white border-r border-slate-200 shadow-sm">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center gap-2.5 px-5 pb-4 border-b border-slate-100">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="font-display text-sm font-bold text-slate-900 tracking-tight">HRIS <span class="text-primary-600">Gampang</span></span>
                    </div>
                    <nav class="mt-5 px-3 space-y-0.5">
                        <a href="{{ route('employee.dashboard') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('employee.dashboard') ? 'text-primary-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('employee.attendances.index') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.attendances.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('employee.attendances.*') ? 'text-primary-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Kehadiran
                        </a>
                        <a href="{{ route('employee.leave-requests.index') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.leave-requests.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('employee.leave-requests.*') ? 'text-primary-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Cuti
                        </a>
                        <a href="{{ route('employee.payrolls.index') }}"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.payrolls.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('employee.payrolls.*') ? 'text-primary-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Slip Gaji
                        </a>
                        <div class="pt-5 mt-4 border-t border-slate-100">
                            <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">Akun</p>
                            <div class="mt-2 space-y-0.5">
                                <a href="{{ route('employee.profile.edit') }}"
                                   class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employee.profile.edit') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('employee.profile.edit') ? 'text-primary-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Main Area --}}
        <div class="flex flex-col flex-1 min-w-0">
            {{-- Topbar --}}
            <div class="sticky top-0 z-30 flex items-center h-16 px-4 sm:px-6 border-b border-slate-200 bg-white/80 backdrop-blur-xl shadow-sm">
                <button @click="sidebarOpen = true" class="lg:hidden mr-3 -ml-1 text-slate-500 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 rounded-lg p-1.5 transition-colors">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="flex-1"></div>

                <div class="hidden sm:flex sm:items-center sm:gap-2">
                    <x-notification-dropdown />
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-300 focus:outline-none">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-primary-100 text-xs font-bold text-primary-700">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-200">
                                <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <x-dropdown-link :href="route('employee.profile.edit')">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ __('Profile') }}
                                    </div>
                                </x-dropdown-link>
                            </div>
                            <div class="border-t border-slate-200 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            {{ __('Log Out') }}
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="flex items-center gap-1 sm:hidden">
                    <x-notification-dropdown />
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-100 text-xs font-bold text-primary-700 shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-200">
                                <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <x-dropdown-link :href="route('employee.profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            </div>
                            <div class="border-t border-slate-200 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            {{-- Content --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <x-toast-notification />
    <x-confirm-modal />
    <x-loading-overlay />
    @stack('scripts')
</body>
</html>
