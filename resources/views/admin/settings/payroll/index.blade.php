<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Payroll</h1>
            <p class="text-sm text-slate-500 mt-1">Atur tarif BPJS dan nilai PTKP untuk perhitungan gaji otomatis</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-medium">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('settings.payroll.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- BPJS Kesehatan --}}
            <div class="card p-4 sm:p-5 mb-5">
                <h3 class="text-base font-semibold text-slate-900 mb-4">BPJS Kesehatan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="label">Tarif Karyawan (%)</label>
                        <input type="number" name="bpjs_kesehatan_employee_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_kesehatan_employee_rate', $settings['bpjs_kesehatan_employee_rate'] ?? '1') }}">
                    </div>
                    <div>
                        <label class="label">Tarif Perusahaan (%)</label>
                        <input type="number" name="bpjs_kesehatan_employer_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_kesehatan_employer_rate', $settings['bpjs_kesehatan_employer_rate'] ?? '4') }}">
                    </div>
                    <div>
                        <label class="label">Max Gaji Pokok (Rp)</label>
                        <input type="number" name="bpjs_kesehatan_max_base" class="input-field w-full"
                            value="{{ old('bpjs_kesehatan_max_base', $settings['bpjs_kesehatan_max_base'] ?? '12000000') }}">
                    </div>
                </div>
            </div>

            {{-- BPJS Ketenagakerjaan --}}
            <div class="card p-4 sm:p-5 mb-5">
                <h3 class="text-base font-semibold text-slate-900 mb-4">BPJS Ketenagakerjaan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="label">JHT Karyawan (%)</label>
                        <input type="number" name="bpjs_jht_employee_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_jht_employee_rate', $settings['bpjs_jht_employee_rate'] ?? '2') }}">
                    </div>
                    <div>
                        <label class="label">JHT Perusahaan (%)</label>
                        <input type="number" name="bpjs_jht_employer_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_jht_employer_rate', $settings['bpjs_jht_employer_rate'] ?? '3.7') }}">
                    </div>
                    <div>
                        <label class="label">JP Karyawan (%)</label>
                        <input type="number" name="bpjs_jp_employee_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_jp_employee_rate', $settings['bpjs_jp_employee_rate'] ?? '1') }}">
                    </div>
                    <div>
                        <label class="label">JP Perusahaan (%)</label>
                        <input type="number" name="bpjs_jp_employer_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_jp_employer_rate', $settings['bpjs_jp_employer_rate'] ?? '2') }}">
                    </div>
                    <div>
                        <label class="label">JKK (%)</label>
                        <input type="number" name="bpjs_jkk_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_jkk_rate', $settings['bpjs_jkk_rate'] ?? '0.54') }}">
                    </div>
                    <div>
                        <label class="label">JKM (%)</label>
                        <input type="number" name="bpjs_jkm_rate" step="0.01" class="input-field w-full"
                            value="{{ old('bpjs_jkm_rate', $settings['bpjs_jkm_rate'] ?? '0.3') }}">
                    </div>
                </div>
            </div>

            {{-- PTKP --}}
            <div class="card p-4 sm:p-5 mb-5">
                <h3 class="text-base font-semibold text-slate-900 mb-4">PTKP (Penghasilan Tidak Kena Pajak) per Tahun</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="label">TK/0 (Rp)</label>
                        <input type="number" name="ptkp_tk0" class="input-field w-full"
                            value="{{ old('ptkp_tk0', $settings['ptkp_tk0'] ?? '54000000') }}">
                    </div>
                    <div>
                        <label class="label">TK/1 (Rp)</label>
                        <input type="number" name="ptkp_tk1" class="input-field w-full"
                            value="{{ old('ptkp_tk1', $settings['ptkp_tk1'] ?? '58500000') }}">
                    </div>
                    <div>
                        <label class="label">TK/2 (Rp)</label>
                        <input type="number" name="ptkp_tk2" class="input-field w-full"
                            value="{{ old('ptkp_tk2', $settings['ptkp_tk2'] ?? '63000000') }}">
                    </div>
                    <div>
                        <label class="label">TK/3 (Rp)</label>
                        <input type="number" name="ptkp_tk3" class="input-field w-full"
                            value="{{ old('ptkp_tk3', $settings['ptkp_tk3'] ?? '67500000') }}">
                    </div>
                    <div>
                        <label class="label">K/0 (Rp)</label>
                        <input type="number" name="ptkp_k0" class="input-field w-full"
                            value="{{ old('ptkp_k0', $settings['ptkp_k0'] ?? '58500000') }}">
                    </div>
                    <div>
                        <label class="label">K/1 (Rp)</label>
                        <input type="number" name="ptkp_k1" class="input-field w-full"
                            value="{{ old('ptkp_k1', $settings['ptkp_k1'] ?? '63000000') }}">
                    </div>
                    <div>
                        <label class="label">K/2 (Rp)</label>
                        <input type="number" name="ptkp_k2" class="input-field w-full"
                            value="{{ old('ptkp_k2', $settings['ptkp_k2'] ?? '67500000') }}">
                    </div>
                    <div>
                        <label class="label">K/3 (Rp)</label>
                        <input type="number" name="ptkp_k3" class="input-field w-full"
                            value="{{ old('ptkp_k3', $settings['ptkp_k3'] ?? '72000000') }}">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-primary-button>Simpan Pengaturan</x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
