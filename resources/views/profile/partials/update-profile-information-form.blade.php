<section>
    <header class="mb-5">
        <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <h2 class="text-base font-semibold text-slate-900">Informasi Profil</h2>
        </div>
        <p class="text-sm text-slate-500 mt-1">Perbarui informasi akun dan alamat email kamu.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="space-y-1.5">
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-600">
                        Alamat email kamu belum diverifikasi.
                        <button form="send-verification" class="underline text-sm text-primary-600 hover:text-primary-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Klik di sini untuk kirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            Link verifikasi baru telah dikirim ke email kamu.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
</section>
