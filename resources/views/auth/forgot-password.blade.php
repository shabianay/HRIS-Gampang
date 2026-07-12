<x-guest-layout>
    <h2 class="text-xl font-bold text-slate-900 mb-1">Lupa password?</h2>
    <p class="text-sm text-slate-500 mb-6 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="space-y-1.5">
            <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                <input id="email" class="input-field pl-10" type="email" name="email" :value="old('email')" required autofocus placeholder="you@company.com" />
            </div>
            @if ($errors->get('email'))
                <ul class="list-none space-y-1">
                    @foreach ($errors->get('email') as $message)
                        <li class="text-sm text-red-600">{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-primary w-full justify-center py-3">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
