<x-employee-layout>
    <div class="space-y-6">

        {{-- Header + Filter Tahun --}}
        <div class="card flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-2xl font-bold text-slate-900">Riwayat Gaji</h1>
                <p class="mt-0.5 text-sm text-slate-500">Daftar slip gaji yang telah diterbitkan</p>
            </div>
            <form method="GET" class="flex items-center gap-3">
                <label class="text-sm font-medium text-slate-500">Tahun</label>
                <select name="year" onchange="this.form.submit()" class="input-field min-w-[320px] px-8 py-2.5 pr-14 text-base">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="card p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total Gaji {{ $selectedYear }}</p>
                        <p class="font-display text-2xl font-bold text-slate-900">Rp {{ number_format($totalReceived, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Slip Terbaru</p>
                        <p class="font-display text-2xl font-bold text-slate-900">{{ $latest ? $latest->period : '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Jumlah Slip</p>
                        <p class="font-display text-2xl font-bold text-slate-900">{{ $payrolls->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Slip Gaji --}}
        @if($payrolls->count())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach($payrolls as $payroll)
                    <div class="card flex flex-col p-6 transition-all hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Periode</p>
                                <p class="font-display text-lg font-bold text-slate-900">{{ $payroll->period }}</p>
                            </div>
                            <span class="badge @if($payroll->status == 'pending') badge @elseif($payroll->status == 'processed') badge-warning @else badge-success @endif">{{ ucfirst($payroll->status) }}</span>
                        </div>
                        <div class="mt-4 border-t border-slate-100 pt-4">
                            <p class="text-xs text-slate-500">Gaji Bersih</p>
                            <p class="font-display text-2xl font-bold text-primary-600">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</p>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-slate-400">Tunjangan</p>
                                <p class="mt-0.5 font-medium text-emerald-600">+ Rp {{ number_format($payroll->total_allowance, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Potongan</p>
                                <p class="mt-0.5 font-medium text-red-600">- Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="mt-5 flex gap-3">
                            <a href="{{ route('employee.payrolls.show', $payroll) }}" class="btn-primary flex-1 items-center justify-center gap-2 text-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat
                            </a>
                            <a href="{{ route('employee.payrolls.print', $payroll) }}" target="_blank" class="btn-secondary flex-1 items-center justify-center gap-2 text-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                PDF
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($payrolls->hasPages())
                <div class="mt-4">
                    {{ $payrolls->links() }}
                </div>
            @endif
        @else
            <div class="card p-12 text-center">
                <svg class="mx-auto mb-3 h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-slate-500">Belum ada data penggajian untuk tahun {{ $selectedYear }}.</p>
            </div>
        @endif
    </div>
</x-employee-layout>
