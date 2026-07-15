<x-admin-layout>
    <div>
        <div class="flex items-center mb-6">
            <a href="{{ route('payrolls.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 mr-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Buat Payroll</h1>
                <p class="text-sm text-slate-500 mt-0.5">Buat payroll untuk pegawai</p>
            </div>
        </div>

        <div class="card">
            <form action="{{ route('payrolls.store') }}" method="POST">
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
                        <x-input-label for="period" value="Periode (YYYY-MM)" />
                        <x-text-input id="period" name="period" type="text" class="block w-full" :value="old('period')" placeholder="2026-07" />
                        <x-input-error :messages="$errors->get('period')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="base_salary" value="Gaji Pokok" />
                        <x-text-input id="base_salary" name="base_salary" type="number" class="block w-full" :value="old('base_salary')" placeholder="5000000" />
                        <x-input-error :messages="$errors->get('base_salary')" class="mt-1" />
                    </div>
                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label value="Komponen Gaji" />
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                            @foreach($salaryComponents as $component)
                                <label class="relative flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-primary-400 has-[:checked]:bg-primary-50/50">
                                    <input type="checkbox" name="salary_components[]" value="{{ $component->id }}" {{ in_array($component->id, old('salary_components', [])) ? 'checked' : '' }} class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 shadow-sm">
                                    <span class="ml-3 text-sm font-medium text-slate-700">{{ $component->name }} <span class="text-xs font-normal text-slate-400">({{ $component->type == 'allowance' ? 'Tunjangan' : 'Potongan' }})</span></span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('salary_components')" class="mt-1" />
                    </div>
                </div>

                {{-- Auto Calculation Info --}}
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Potongan Wajib Otomatis</p>
                            <p class="text-xs text-blue-600 mt-1">BPJS Kesehatan (1%), BPJS Ketenagakerjaan (JHT 2% + JP 1%), dan PPh Pasal 21 akan dihitung otomatis berdasarkan gaji pokok, tunjangan, dan status PTKP pegawai.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ route('payrolls.index') }}" class="btn-secondary">Batal</a>
                    <x-primary-button>Buat Payroll</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
