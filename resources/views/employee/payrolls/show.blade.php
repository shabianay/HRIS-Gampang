<x-employee-layout>
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('employee.payrolls.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <a href="{{ route('employee.payrolls.print', $payroll) }}" class="btn-secondary text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / PDF
        </a>
    </div>

    <div class="card p-6 sm:p-8">
        <div class="text-center mb-8 pb-6 border-b border-slate-200">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">SLIP GAJI</h1>
            <p class="text-sm text-slate-500 mt-1">Periode: {{ $payroll->period }}</p>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pegawai</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $payroll->employee->full_name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">NIK</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $payroll->employee->nik }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Departemen</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $payroll->employee->department?->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jabatan</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $payroll->employee->position?->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</p>
                <span class="badge mt-0.5
                    @if($payroll->status == 'draft') badge
                    @elseif($payroll->status == 'processed') badge-warning
                    @else badge-success
                    @endif">
                    {{ ucfirst($payroll->status) }}
                </span>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-base font-semibold text-slate-900 mb-4 border-b border-slate-200 pb-3">Rincian Gaji</h3>
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Komponen</th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Tipe</th>
                            <th class="px-4 py-2.5 text-right text-xs font-semibold text-slate-500 uppercase">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="bg-slate-50/50">
                            <td class="px-4 py-3 text-sm font-medium text-slate-900">Gaji Pokok</td>
                            <td class="px-4 py-3 text-sm text-slate-500">Pokok</td>
                            <td class="px-4 py-3 text-sm text-right text-slate-900 font-medium">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                        </tr>
                        @if($payroll->details)
                            @foreach($payroll->details['allowances'] ?? [] as $key => $amount)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-900">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge badge-success">Tunjangan</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-emerald-600">+ Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            @foreach($payroll->details['deductions'] ?? [] as $key => $amount)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-900">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge badge-danger">Potongan</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-red-600">- Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot class="bg-slate-50">
                        <tr>
                            <td class="px-4 py-3 text-sm font-semibold text-slate-900" colspan="2">Total Tunjangan</td>
                            <td class="px-4 py-3 text-sm font-semibold text-right text-emerald-600">+ Rp {{ number_format($payroll->total_allowance, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-semibold text-slate-900" colspan="2">Total Potongan</td>
                            <td class="px-4 py-3 text-sm font-semibold text-right text-red-600">- Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-t-2 border-slate-200">
                            <td class="px-4 py-4 text-base font-bold text-slate-900" colspan="2">Gaji Bersih</td>
                            <td class="px-4 py-4 text-base font-bold text-right text-primary-600">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
        </div>

        <div class="text-center text-xs text-slate-400 mt-8 pt-4 border-t border-slate-200">
            <p>Slip gaji ini digenerate secara otomatis oleh sistem HRIS Gampang</p>
        </div>
    </div>
</x-employee-layout>
