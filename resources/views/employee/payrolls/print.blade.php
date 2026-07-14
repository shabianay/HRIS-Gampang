<x-employee-layout>
    <style>
        @media print {
            body * { visibility: hidden; }
            #payslip, #payslip * { visibility: visible; }
            #payslip { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>

    <div class="mb-6 no-print">
        <a href="{{ route('employee.payrolls.show', $payroll) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div id="payslip" class="card p-6 sm:p-10">

        {{-- Kop Surat --}}
        <div class="mb-6 border-b-2 border-slate-300 pb-5">
                <div>
                <h2 class="text-lg font-bold text-slate-900">PT. HRIS Gampang</h2>
                <p class="text-xs text-slate-500">Jl. Merdeka No. 123, Kelapa Gading, Jakarta Utara</p>
                <p class="text-xs text-slate-500">Telp: (021) 1234-5678 &middot; Email: hris@gampang.com</p>
            </div>
        </div>

        {{-- Title --}}
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">SLIP GAJI</h1>
            <p class="mt-1 text-sm text-slate-500">Periode: <span class="font-semibold text-slate-700">{{ $payroll->period }}</span></p>
        </div>

        {{-- Employee Info --}}
        <div class="mb-8 grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Nama Pegawai</p>
                <p class="mt-0.5 text-sm font-medium text-slate-900">{{ $payroll->employee->full_name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">NIK</p>
                <p class="mt-0.5 text-sm font-medium text-slate-900">{{ $payroll->employee->nik }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Departemen</p>
                <p class="mt-0.5 text-sm font-medium text-slate-900">{{ $payroll->employee->department?->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Jabatan</p>
                <p class="mt-0.5 text-sm font-medium text-slate-900">{{ $payroll->employee->position?->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</p>
                <span class="badge mt-0.5 {{ $payroll->status == 'paid' ? 'badge-success' : 'badge' }}">{{ ucfirst($payroll->status) }}</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="mb-8">
            <h3 class="mb-4 border-b border-slate-200 pb-3 text-base font-semibold text-slate-900">Rincian Gaji</h3>
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold uppercase text-slate-500">Komponen</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold uppercase text-slate-500">Tipe</th>
                        <th class="px-4 py-2.5 text-right text-xs font-semibold uppercase text-slate-500">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="bg-slate-50/50">
                        <td class="px-4 py-3 text-sm font-medium text-slate-900">Gaji Pokok</td>
                        <td class="px-4 py-3 text-sm text-slate-500">Pokok</td>
                        <td class="px-4 py-3 text-right text-sm font-medium text-slate-900">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                    </tr>
                    @if($payroll->details)
                        @foreach($payroll->details['allowances'] ?? [] as $key => $amount)
                            <tr>
                                <td class="px-4 py-3 text-sm text-slate-900">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                <td class="px-4 py-3"><span class="badge badge-success">Tunjangan</span></td>
                                <td class="px-4 py-3 text-right text-sm text-emerald-600">+ Rp {{ number_format($amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        @foreach($payroll->details['deductions'] ?? [] as $key => $amount)
                            <tr>
                                <td class="px-4 py-3 text-sm text-slate-900">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                <td class="px-4 py-3"><span class="badge badge-danger">Potongan</span></td>
                                <td class="px-4 py-3 text-right text-sm text-red-600">- Rp {{ number_format($amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot class="bg-slate-50">
                    <tr>
                        <td class="px-4 py-3 text-sm font-semibold text-slate-900" colspan="2">Total Tunjangan</td>
                        <td class="px-4 py-3 text-right text-sm font-semibold text-emerald-600">+ Rp {{ number_format($payroll->total_allowance, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm font-semibold text-slate-900" colspan="2">Total Potongan</td>
                        <td class="px-4 py-3 text-right text-sm font-semibold text-red-600">- Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-t-2 border-slate-200">
                        <td class="px-4 py-4 text-base font-bold text-slate-900" colspan="2">Gaji Bersih</td>
                        <td class="px-4 py-4 text-right text-base font-bold text-primary-600">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Tanda Tangan --}}
        <div class="mb-8 mt-10 grid grid-cols-2 gap-8">
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Penerima,</p>
                <div class="mt-16 border-b-2 border-dotted border-slate-300">&nbsp;</div>
                <p class="mt-1 text-sm font-medium text-slate-900">{{ $payroll->employee->full_name }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Mengetahui,</p>
                <div class="mt-16 border-b-2 border-dotted border-slate-300">&nbsp;</div>
                <p class="mt-1 text-sm font-medium text-slate-900">HRD &amp; Finance</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="border-t border-slate-200 pt-4 text-center text-xs text-slate-400">
            <p>Slip gaji ini digenerate secara otomatis oleh sistem HRIS Gampang</p>
            <p class="mt-0.5">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</x-employee-layout>

<script>
    window.onload = function() { window.print(); };
</script>
