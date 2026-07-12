<x-admin-layout>
    <div>
        <div class="flex items-center mb-6">
            <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 mr-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Pegawai</h1>
                <p class="text-sm text-slate-500 mt-0.5">Lengkapi data pegawai baru</p>
            </div>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('employees.store') }}" x-data="{ userId: '', users: {{ $users->toJson() }} }">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <x-input-label for="user_id" value="User" />
                        <select id="user_id" name="user_id" x-model="userId" class="input-field">
                            <option value="">Pilih User</option>
                            <template x-for="user in users" :key="user.id">
                                <option :value="user.id" x-text="user.email"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="nik" value="NIK" />
                        <x-text-input id="nik" name="nik" type="text" class="block w-full" :value="old('nik')" required />
                        <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="full_name" value="Nama Lengkap" />
                        <x-text-input id="full_name" name="full_name" type="text" class="block w-full" :value="old('full_name')" x-bind:value="userId ? users.find(u => u.id == userId)?.name ?? '' : ''" required />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="gender" value="Jenis Kelamin" />
                        <select id="gender" name="gender" class="input-field">
                            <option value="">Pilih</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="birth_date" value="Tanggal Lahir" />
                        <x-text-input id="birth_date" name="birth_date" type="date" class="block w-full" :value="old('birth_date')" />
                        <x-input-error :messages="$errors->get('birth_date')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="birth_place" value="Tempat Lahir" />
                        <x-text-input id="birth_place" name="birth_place" type="text" class="block w-full" :value="old('birth_place')" />
                        <x-input-error :messages="$errors->get('birth_place')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="phone" value="No. Telepon" />
                        <x-text-input id="phone" name="phone" type="text" class="block w-full" :value="old('phone')" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="department_id" value="Departemen" />
                        <select id="department_id" name="department_id" class="input-field">
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="position_id" value="Jabatan" />
                        <select id="position_id" name="position_id" class="input-field">
                            <option value="">Pilih Jabatan</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('position_id')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="join_date" value="Tanggal Bergabung" />
                        <x-text-input id="join_date" name="join_date" type="date" class="block w-full" :value="old('join_date')" />
                        <x-input-error :messages="$errors->get('join_date')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="input-field">
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                            <option value="resign" {{ old('status') == 'resign' ? 'selected' : '' }}>Resign</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label for="address" value="Alamat" />
                        <textarea id="address" name="address" rows="2" class="input-field">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6 mt-8">
                    <h3 class="text-base font-semibold text-slate-900 mb-4">Informasi Perbankan & Pajak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <x-input-label for="bank_name" value="Nama Bank" />
                            <x-text-input id="bank_name" name="bank_name" type="text" class="block w-full" :value="old('bank_name')" />
                            <x-input-error :messages="$errors->get('bank_name')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bank_account" value="No. Rekening" />
                            <x-text-input id="bank_account" name="bank_account" type="text" class="block w-full" :value="old('bank_account')" />
                            <x-input-error :messages="$errors->get('bank_account')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bank_account_name" value="Nama Rekening" />
                            <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="block w-full" :value="old('bank_account_name')" />
                            <x-input-error :messages="$errors->get('bank_account_name')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="npwp" value="NPWP" />
                            <x-text-input id="npwp" name="npwp" type="text" class="block w-full" :value="old('npwp')" />
                            <x-input-error :messages="$errors->get('npwp')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bpjs_kesehatan" value="BPJS Kesehatan" />
                            <x-text-input id="bpjs_kesehatan" name="bpjs_kesehatan" type="text" class="block w-full" :value="old('bpjs_kesehatan')" />
                            <x-input-error :messages="$errors->get('bpjs_kesehatan')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bpjs_ketenagakerjaan" value="BPJS Ketenagakerjaan" />
                            <x-text-input id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan" type="text" class="block w-full" :value="old('bpjs_ketenagakerjaan')" />
                            <x-input-error :messages="$errors->get('bpjs_ketenagakerjaan')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6 mt-8">
                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label for="notes" value="Catatan" />
                        <textarea id="notes" name="notes" rows="2" class="input-field">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ route('employees.index') }}" class="btn-secondary">Batal</a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
