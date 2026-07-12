<x-guest-layout>
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    <h2 class="text-xl font-bold text-slate-900 mb-1">Masuk ke akun Anda</h2>
    <p class="text-sm text-slate-500 mb-6">Masukkan email dan password untuk melanjutkan</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-1.5">
            <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                <input id="email" class="input-field pl-10" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@company.com" />
            </div>
            @if ($errors->get('email'))
                <ul class="list-none space-y-1">
                    @foreach ($errors->get('email') as $message)
                        <li class="text-sm text-red-600">{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-4 space-y-1.5">
            <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <input id="password" class="input-field pl-10" type="password" name="password" required autocomplete="current-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" />
            </div>
            @if ($errors->get('password'))
                <ul class="list-none space-y-1">
                    @foreach ($errors->get('password') as $message)
                        <li class="text-sm text-red-600">{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 focus:ring-offset-0" name="remember">
                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary-600 hover:text-primary-700 font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-primary w-full justify-center py-3">
                {{ __('Log in') }}
            </button>
        </div>

        <p class="mt-4 text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">Daftar</a>
        </p>
    </form>
</x-guest-layout>
