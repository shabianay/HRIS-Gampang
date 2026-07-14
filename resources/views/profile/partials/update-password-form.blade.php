<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    <div class="space-y-1.5">
        <x-input-label for="update_password_current_password" value="Password Saat Ini" />
        <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full" autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" />
    </div>

    <div class="space-y-1.5">
        <x-input-label for="update_password_password" value="Password Baru" />
        <x-text-input id="update_password_password" name="password" type="password" class="block w-full" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password')" />
    </div>

    <div class="space-y-1.5">
        <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password" />
        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan
        </button>
        @if (session('status') === 'password-updated')
            <span class="text-xs font-medium text-emerald-600 flex items-center gap-1.5">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Tersimpan!
            </span>
        @endif
    </div>
</form>
