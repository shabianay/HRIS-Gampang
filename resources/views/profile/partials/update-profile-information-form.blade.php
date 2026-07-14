<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route(auth()->user()->role === 'pegawai' ? 'employee.profile.update' : 'profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="space-y-1.5">
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl">
            <p class="text-xs text-amber-700">
                Alamat email kamu belum diverifikasi.
                <button form="send-verification" class="underline font-medium hover:text-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 rounded">
                    Klik di sini untuk kirim ulang email verifikasi.
                </button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-xs font-medium text-emerald-600">
                    Link verifikasi baru telah dikirim ke email kamu.
                </p>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan
        </button>
        @if (session('status') === 'profile-updated')
            <span class="text-xs font-medium text-emerald-600 flex items-center gap-1.5">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Tersimpan!
            </span>
        @endif
    </div>
</form>
