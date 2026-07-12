<x-admin-layout>
    <div>
        <div class="flex items-center mb-6">
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 mr-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Input Kehadiran Manual</h1>
                <p class="text-sm text-slate-500 mt-0.5">Catat kehadiran pegawai secara manual</p>
            </div>
        </div>

        <div class="card">
            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <x-input-label for="employee_id" value="Pegawai" />
                        <select id="employee_id" name="employee_id" class="input-field">
                            <option value="">Pilih Pegawai</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }} ({{ $employee->nik }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('employee_id')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="date" value="Tanggal" />
                        <x-text-input id="date" name="date" type="date" class="block w-full" :value="old('date')" />
                        <x-input-error :messages="$errors->get('date')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="clock_in" value="Clock In" />
                        <x-text-input id="clock_in" name="clock_in" type="time" class="block w-full" :value="old('clock_in')" />
                        <x-input-error :messages="$errors->get('clock_in')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="clock_out" value="Clock Out" />
                        <x-text-input id="clock_out" name="clock_out" type="time" class="block w-full" :value="old('clock_out')" />
                        <x-input-error :messages="$errors->get('clock_out')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="input-field">
                            <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="absen" {{ old('status') == 'absen' ? 'selected' : '' }}>Absen</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="late_minutes" value="Keterlambatan (menit)" />
                        <x-text-input id="late_minutes" name="late_minutes" type="number" class="block w-full" :value="old('late_minutes')" />
                        <x-input-error :messages="$errors->get('late_minutes')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="location" value="Lokasi" />
                        <x-text-input id="location" name="location" type="text" class="block w-full" :value="old('location')" />
                        <x-input-error :messages="$errors->get('location')" class="mt-1" />
                    </div>
                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label for="notes" value="Catatan" />
                        <textarea id="notes" name="notes" rows="2" class="input-field">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ route('attendances.index') }}" class="btn-secondary">Batal</a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
