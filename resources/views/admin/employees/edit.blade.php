<x-admin-layout>
    <div>
        <div class="flex items-center mb-6">
            <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 mr-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Pegawai</h1>
                <p class="text-sm text-slate-500 mt-0.5">Perbarui data {{ $employee->full_name }}</p>
            </div>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('employees.update', $employee) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <x-input-label for="nik" value="NIK" />
                        <x-text-input id="nik" name="nik" type="text" class="block w-full" :value="old('nik', $employee->nik)" required />
                        <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="full_name" value="Nama Lengkap" />
                        <x-text-input id="full_name" name="full_name" type="text" class="block w-full" :value="old('full_name', $employee->full_name)" required />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="email" value="Email (Akun Login)" />
                        <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $employee->user->email ?? '')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="password" value="Password (kosongkan jika tidak diubah)" />
                        <x-text-input id="password" name="password" type="password" class="block w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="role" value="Role / Hak Akses" />
                        <select id="role" name="role" class="input-field">
                            <option value="pegawai" {{ old('role', $employee->user->role ?? 'pegawai') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            <option value="admin_hr" {{ old('role', $employee->user->role ?? '') == 'admin_hr' ? 'selected' : '' }}>Admin HR</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="gender" value="Jenis Kelamin" />
                        <select id="gender" name="gender" class="input-field">
                            <option value="">Pilih</option>
                            <option value="L" {{ old('gender', $employee->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $employee->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="birth_date" value="Tanggal Lahir" />
                        <x-text-input id="birth_date" name="birth_date" type="date" class="block w-full" :value="old('birth_date', $employee->birth_date?->format('Y-m-d'))" />
                        <x-input-error :messages="$errors->get('birth_date')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="birth_place" value="Tempat Lahir" />
                        <x-text-input id="birth_place" name="birth_place" type="text" class="block w-full" :value="old('birth_place', $employee->birth_place)" />
                        <x-input-error :messages="$errors->get('birth_place')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="phone" value="No. Telepon" />
                        <x-text-input id="phone" name="phone" type="text" class="block w-full" :value="old('phone', $employee->phone)" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="department_id" value="Departemen" />
                        <select id="department_id" name="department_id" class="input-field">
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="position_id" value="Jabatan" />
                        <select id="position_id" name="position_id" class="input-field">
                            <option value="">Pilih Jabatan</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ old('position_id', $employee->position_id) == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('position_id')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="join_date" value="Tanggal Bergabung" />
                        <x-text-input id="join_date" name="join_date" type="date" class="block w-full" :value="old('join_date', $employee->join_date?->format('Y-m-d'))" />
                        <x-input-error :messages="$errors->get('join_date')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="input-field">
                            <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $employee->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="cuti" {{ old('status', $employee->status) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                            <option value="resign" {{ old('status', $employee->status) == 'resign' ? 'selected' : '' }}>Resign</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>
                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label for="address" value="Alamat" />
                        <textarea id="address" name="address" rows="2" class="input-field">{{ old('address', $employee->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6 mt-8">
                    <h3 class="text-base font-semibold text-slate-900 mb-4">Informasi Perbankan & Pajak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <x-input-label for="bank_name" value="Nama Bank" />
                            <x-text-input id="bank_name" name="bank_name" type="text" class="block w-full" :value="old('bank_name', $employee->bank_name)" />
                            <x-input-error :messages="$errors->get('bank_name')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bank_account" value="No. Rekening" />
                            <x-text-input id="bank_account" name="bank_account" type="text" class="block w-full" :value="old('bank_account', $employee->bank_account)" />
                            <x-input-error :messages="$errors->get('bank_account')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bank_account_name" value="Nama Rekening" />
                            <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="block w-full" :value="old('bank_account_name', $employee->bank_account_name)" />
                            <x-input-error :messages="$errors->get('bank_account_name')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="npwp" value="NPWP" />
                            <x-text-input id="npwp" name="npwp" type="text" class="block w-full" :value="old('npwp', $employee->npwp)" />
                            <x-input-error :messages="$errors->get('npwp')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bpjs_kesehatan" value="BPJS Kesehatan" />
                            <x-text-input id="bpjs_kesehatan" name="bpjs_kesehatan" type="text" class="block w-full" :value="old('bpjs_kesehatan', $employee->bpjs_kesehatan)" />
                            <x-input-error :messages="$errors->get('bpjs_kesehatan')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="bpjs_ketenagakerjaan" value="BPJS Ketenagakerjaan" />
                            <x-text-input id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan" type="text" class="block w-full" :value="old('bpjs_ketenagakerjaan', $employee->bpjs_ketenagakerjaan)" />
                            <x-input-error :messages="$errors->get('bpjs_ketenagakerjaan')" class="mt-1" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="ptkp_status" value="Status PTKP (PPh 21)" />
                            <select id="ptkp_status" name="ptkp_status" class="input-field">
                                <option value="">Pilih Status PTKP</option>
                                @foreach(\App\Services\PayrollCalculationService::getPtkpStatuses() as $key => $label)
                                    <option value="{{ $key }}" {{ old('ptkp_status', $employee->ptkp_status) == $key ? 'selected' : '' }}>{{ $key }} - {{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('ptkp_status')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6 mt-8">
                    <div class="space-y-1.5">
                        <x-input-label for="notes" value="Catatan" />
                        <textarea id="notes" name="notes" rows="2" class="input-field">{{ old('notes', $employee->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ route('employees.index') }}" class="btn-secondary">Batal</a>
                    <x-primary-button>Perbarui</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
