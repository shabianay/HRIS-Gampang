@php
    $layout = auth()->user()->role === 'pegawai' ? 'employee-layout' : 'admin-layout';
    $isPegawai = auth()->user()->role === 'pegawai';
@endphp
<x-dynamic-component :component="$layout">
    <div x-data="{ activeTab: 'profil' }">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
            <div class="flex items-center gap-5 p-5 sm:p-6">
                <div class="relative">
                    <span
                        class="inline-flex h-20 w-20 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 items-center justify-center text-white text-2xl font-bold shadow-md ring-4 ring-white">
                        {{ substr($user->name, 0, 1) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">{{ $user->name }}</h1>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-3">
                        <span
                            class="text-xs font-medium px-3 py-1 rounded-full {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        @if ($employee)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-8">
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">NIK</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $employee->nik }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Departemen</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $employee->department?->name ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Jabatan</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $employee->position?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Bergabung</p>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tab Navigation --}}
        <div class="border-b border-slate-200 mb-6">
            <nav class="flex gap-1 -mb-px">
                <button @click="activeTab = 'profil'"
                    :class="activeTab === 'profil' ? 'border-primary-500 text-primary-600' :
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="px-4 py-3 text-sm font-semibold border-b-2 transition-colors flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil
                </button>
                @if ($employee)
                    <button @click="activeTab = 'karyawan'"
                        :class="activeTab === 'karyawan' ? 'border-primary-500 text-primary-600' :
                            'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="px-4 py-3 text-sm font-semibold border-b-2 transition-colors flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        Data Karyawan
                    </button>
                @endif
                <button @click="activeTab = 'keamanan'"
                    :class="activeTab === 'keamanan' ? 'border-primary-500 text-primary-600' :
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="px-4 py-3 text-sm font-semibold border-b-2 transition-colors flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Keamanan
                </button>
            </nav>
        </div>

        {{-- Tab: Profil --}}
        <div x-show="activeTab === 'profil'" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Sidebar Info --}}
                <div class="lg:col-span-4">
                    @if ($employee)
                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                            <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-900">Info Kepegawaian</h3>
                                    <p class="text-xs text-slate-500">Detail status dan data diri</p>
                                </div>
                            </div>
                            <div class="space-y-0">
                                <div
                                    class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-b-0">
                                    <span class="text-xs text-slate-500">Tempat Lahir</span>
                                    <span
                                        class="text-xs font-semibold text-slate-900">{{ $employee->birth_place ?? '-' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-b-0">
                                    <span class="text-xs text-slate-500">Tanggal Lahir</span>
                                    <span
                                        class="text-xs font-semibold text-slate-900">{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d M Y') : '-' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-b-0">
                                    <span class="text-xs text-slate-500">Jenis Kelamin</span>
                                    <span
                                        class="text-xs font-semibold text-slate-900">{{ $employee->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-b-0">
                                    <span class="text-xs text-slate-500">Telepon</span>
                                    <span
                                        class="text-xs font-semibold text-slate-900">{{ $employee->phone ?? '-' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-b-0">
                                    <span class="text-xs text-slate-500">Alamat</span>
                                    <p class="text-xs font-semibold text-slate-900">{{ $employee->address ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tab: Data Karyawan --}}
        @if ($employee)
            <div x-show="activeTab === 'karyawan'" x-transition>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-3 pb-5 border-b border-slate-100 mb-5">
                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">Data Karyawan</h3>
                                <p class="text-xs text-slate-500">Informasi pribadi dan data kepegawaian</p>
                            </div>
                        </div>
                        {{-- Form --}}
                        <form method="post"
                            action="{{ route($isPegawai ? 'employee.profile.update' : 'profile.update') }}"
                            class="space-y-6">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">

                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Data
                                    Pribadi</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div class="space-y-1.5">
                                        <x-input-label for="phone" value="No. Telepon" />
                                        <x-text-input id="phone" name="phone" type="text"
                                            class="block w-full" :value="old('phone', $employee->phone)" />
                                        <x-input-error :messages="$errors->get('phone')" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <x-input-label for="address" value="Alamat" />
                                        <textarea id="address" name="address" rows="3" class="input-field">{{ old('address', $employee->address) }}</textarea>
                                        <x-input-error :messages="$errors->get('address')" />
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 pt-6">
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">
                                    Informasi Bank & Legal</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div class="space-y-1.5">
                                        <x-input-label for="bank_name" value="Nama Bank" />
                                        <select id="bank_name" name="bank_name" class="input-field">
                                            <option value="">Pilih Bank</option>
                                            @foreach (['BCA', 'Mandiri', 'BNI', 'BRI', 'BTN', 'CIMB Niaga', 'Danamon', 'Panin', 'Permata', 'Maybank'] as $bank)
                                                <option value="{{ $bank }}"
                                                    {{ old('bank_name', $employee->bank_name) == $bank ? 'selected' : '' }}>
                                                    {{ $bank }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('bank_name')" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <x-input-label for="bank_account" value="No. Rekening" />
                                        <x-text-input id="bank_account" name="bank_account" type="text"
                                            class="block w-full" :value="old('bank_account', $employee->bank_account)" />
                                        <x-input-error :messages="$errors->get('bank_account')" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <x-input-label for="bank_account_name" value="Nama Pemilik Rekening" />
                                        <x-text-input id="bank_account_name" name="bank_account_name" type="text"
                                            class="block w-full" :value="old('bank_account_name', $employee->bank_account_name)" />
                                        <x-input-error :messages="$errors->get('bank_account_name')" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <x-input-label for="npwp" value="NPWP" />
                                        <x-text-input id="npwp" name="npwp" type="text"
                                            class="block w-full" :value="old('npwp', $employee->npwp)"
                                            placeholder="XX.XXX.XXX.X-XXX.XXX" />
                                        <x-input-error :messages="$errors->get('npwp')" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <x-input-label for="bpjs_kesehatan" value="BPJS Kesehatan" />
                                        <x-text-input id="bpjs_kesehatan" name="bpjs_kesehatan" type="text"
                                            class="block w-full" :value="old('bpjs_kesehatan', $employee->bpjs_kesehatan)" />
                                        <x-input-error :messages="$errors->get('bpjs_kesehatan')" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <x-input-label for="bpjs_ketenagakerjaan" value="BPJS Ketenagakerjaan" />
                                        <x-text-input id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan"
                                            type="text" class="block w-full" :value="old('bpjs_ketenagakerjaan', $employee->bpjs_ketenagakerjaan)" />
                                        <x-input-error :messages="$errors->get('bpjs_ketenagakerjaan')" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                                <button type="submit" class="btn-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tab: Keamanan --}}
        <div x-show="activeTab === 'keamanan'" x-transition>
            <div class="max-w-lg">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-3 pb-5 border-b border-slate-100 mb-5">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">Keamanan Akun</h3>
                                <p class="text-xs text-slate-500">Perbarui password akun</p>
                            </div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('put')
                            <div class="space-y-1.5">
                                <x-input-label for="update_password_current_password" value="Password Saat Ini" />
                                <x-text-input id="update_password_current_password" name="current_password"
                                    type="password" class="block w-full" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label for="update_password_password" value="Password Baru" />
                                <x-text-input id="update_password_password" name="password" type="password"
                                    class="block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label for="update_password_password_confirmation"
                                    value="Konfirmasi Password" />
                                <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                                    type="password" class="block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
                            </div>
                            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                                <button type="submit" class="btn-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Data
                                </button>
                                @if (session('status') === 'password-updated')
                                    <span class="text-xs font-medium text-emerald-600 flex items-center gap-1.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Tersimpan!
                                    </span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-dynamic-component>
