@php $layout = auth()->user()->role === 'pegawai' ? 'employee-layout' : 'admin-layout'; @endphp
<x-dynamic-component :component="$layout">
    <div class="space-y-8">

        {{-- Profile Header --}}
        <div class="card p-6 sm:p-8">
            <div class="flex items-center gap-5">
                <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg shadow-primary-500/20 text-xl font-bold text-white">
                    {{ substr($user->name, 0, 1) }}
                </span>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-bold text-slate-900 truncate">{{ $user->name }}</h1>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="badge @if($user->role == 'admin_hr') badge-success @else badge @endif">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                        @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Profile Information --}}
        <div class="card p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Employee Data --}}
        @if($employee)
        <div class="card p-6 sm:p-8">
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div class="flex items-center gap-2 pb-5 border-b border-slate-200">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    <h2 class="text-base font-semibold text-slate-900">Data Karyawan</h2>
                </div>

                {{-- Read-only info --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pb-5 border-b border-slate-100">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">NIK</p>
                        <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $employee->nik }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Departemen</p>
                        <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $employee->department?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jabatan</p>
                        <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $employee->position?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</p>
                        <span class="badge mt-0.5
                            @if($employee->status == 'aktif') badge-success
                            @elseif($employee->status == 'nonaktif') badge-danger
                            @elseif($employee->status == 'cuti') badge-warning
                            @else badge
                            @endif">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Masuk</p>
                        <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>

                {{-- Editable fields --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <x-input-label for="full_name" value="Nama Lengkap" />
                        <x-text-input id="full_name" name="full_name" type="text" class="block w-full" :value="old('full_name', $employee->full_name)" />
                        <x-input-error :messages="$errors->get('full_name')" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="gender" value="Jenis Kelamin" />
                        <select id="gender" name="gender" class="input-field">
                            <option value="">Pilih</option>
                            <option value="L" {{ old('gender', $employee->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $employee->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="birth_place" value="Tempat Lahir" />
                        <x-text-input id="birth_place" name="birth_place" type="text" class="block w-full" :value="old('birth_place', $employee->birth_place)" />
                        <x-input-error :messages="$errors->get('birth_place')" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="birth_date" value="Tanggal Lahir" />
                        <x-text-input id="birth_date" name="birth_date" type="date" class="block w-full" :value="old('birth_date', $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '')" />
                        <x-input-error :messages="$errors->get('birth_date')" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="phone" value="No. Telepon" />
                        <x-text-input id="phone" name="phone" type="text" class="block w-full" :value="old('phone', $employee->phone)" />
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label for="address" value="Alamat" />
                        <textarea id="address" name="address" rows="2" class="input-field">{{ old('address', $employee->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                </div>

                <hr class="border-slate-200">

                {{-- Bank & legal info --}}
                <div>
                    <h3 class="text-sm font-semibold text-slate-700 mb-4">Informasi Bank & Legal</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <x-input-label for="bank_name" value="Nama Bank" />
                            <select id="bank_name" name="bank_name" class="input-field">
                                <option value="">Pilih Bank</option>
                                @foreach(['BCA', 'Mandiri', 'BNI', 'BRI', 'BTN', 'CIMB Niaga', 'Danamon', 'Panin', 'Permata', 'Maybank'] as $bank)
                                    <option value="{{ $bank }}" {{ old('bank_name', $employee->bank_name) == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('bank_name')" />
                        </div>

                        <div class="space-y-1.5">
                            <x-input-label for="bank_account" value="No. Rekening" />
                            <x-text-input id="bank_account" name="bank_account" type="text" class="block w-full" :value="old('bank_account', $employee->bank_account)" />
                            <x-input-error :messages="$errors->get('bank_account')" />
                        </div>

                        <div class="space-y-1.5">
                            <x-input-label for="bank_account_name" value="Nama Pemilik Rekening" />
                            <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="block w-full" :value="old('bank_account_name', $employee->bank_account_name)" />
                            <x-input-error :messages="$errors->get('bank_account_name')" />
                        </div>

                        <div class="space-y-1.5">
                            <x-input-label for="npwp" value="NPWP" />
                            <x-text-input id="npwp" name="npwp" type="text" class="block w-full" :value="old('npwp', $employee->npwp)" placeholder="XX.XXX.XXX.X-XXX.XXX" />
                            <x-input-error :messages="$errors->get('npwp')" />
                        </div>

                        <div class="space-y-1.5">
                            <x-input-label for="bpjs_kesehatan" value="BPJS Kesehatan" />
                            <x-text-input id="bpjs_kesehatan" name="bpjs_kesehatan" type="text" class="block w-full" :value="old('bpjs_kesehatan', $employee->bpjs_kesehatan)" />
                            <x-input-error :messages="$errors->get('bpjs_kesehatan')" />
                        </div>

                        <div class="space-y-1.5">
                            <x-input-label for="bpjs_ketenagakerjaan" value="BPJS Ketenagakerjaan" />
                            <x-text-input id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan" type="text" class="block w-full" :value="old('bpjs_ketenagakerjaan', $employee->bpjs_ketenagakerjaan)" />
                            <x-input-error :messages="$errors->get('bpjs_ketenagakerjaan')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" class="btn-primary">Simpan Data Karyawan</button>
                </div>
            </form>
        </div>
        @endif

        {{-- Update Password --}}
        <div class="card p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

    </div>
</x-dynamic-component>
