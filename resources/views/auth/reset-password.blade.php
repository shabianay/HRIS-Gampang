<x-guest-layout>
    <h2 class="text-xl font-bold text-slate-900 mb-1">Reset password</h2>
    <p class="text-sm text-slate-500 mb-6">Masukkan password baru Anda</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-1.5">
            <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                <input id="email" class="input-field pl-10" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="you@company.com" />
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
                <input id="password" class="input-field pl-10" type="password" name="password" required autocomplete="new-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" />
            </div>
            @if ($errors->get('password'))
                <ul class="list-none space-y-1">
                    @foreach ($errors->get('password') as $message)
                        <li class="text-sm text-red-600">{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-4 space-y-1.5">
            <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Password</label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <input id="password_confirmation" class="input-field pl-10" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" />
            </div>
            @if ($errors->get('password_confirmation'))
                <ul class="list-none space-y-1">
                    @foreach ($errors->get('password_confirmation') as $message)
                        <li class="text-sm text-red-600">{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-primary w-full justify-center py-3">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
