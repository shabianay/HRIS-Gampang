<x-admin-layout>
    <div>
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="card p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Edit User</h2>
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="label">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field">
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <label class="label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field">
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div>
                        <label class="label">Role</label>
                        <select name="role" class="input-field">
                            <option value="admin_hr" {{ old('role', $user->role) == 'admin_hr' ? 'selected' : '' }}>Admin HR</option>
                            <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" />
                    </div>
                    <div>
                        <label class="flex items-center gap-3 mt-6">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded text-primary-600 focus:ring-primary-500">
                            <span class="text-sm font-medium text-slate-900">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-3">
                    <x-primary-button>Simpan Perubahan</x-primary-button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>

            @if($user->id !== auth()->id())
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menonaktifkan user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger text-sm">Nonaktifkan User</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
