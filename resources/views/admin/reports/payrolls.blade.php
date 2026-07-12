<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Laporan Penggajian</h1>
            <p class="text-sm text-slate-500 mt-1">Rekap data penggajian pegawai</p>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mb-6">
            <div class="bg-primary-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-primary-600">{{ $summary['count'] }}</p>
                <p class="text-xs text-primary-500 font-medium">Total Payroll</p>
            </div>
            <div class="bg-emerald-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600">{{ $summary['paid'] }}</p>
                <p class="text-xs text-emerald-500 font-medium">Dibayar</p>
            </div>
            <div class="bg-amber-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ $summary['draft'] }}</p>
                <p class="text-xs text-amber-500 font-medium">Draft</p>
            </div>
            <div class="bg-emerald-50 rounded-xl p-4 text-center">
                <p class="text-lg font-bold text-emerald-600">Rp {{ number_format($summary['total_allowance'], 0, ',', '.') }}</p>
                <p class="text-xs text-emerald-500 font-medium">Total Tunjangan</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4 text-center">
                <p class="text-lg font-bold text-red-600">Rp {{ number_format($summary['total_deduction'], 0, ',', '.') }}</p>
                <p class="text-xs text-red-500 font-medium">Total Potongan</p>
            </div>
            <div class="bg-slate-900 rounded-xl p-4 text-center">
                <p class="text-lg font-bold text-white">Rp {{ number_format($summary['total_gaji'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-300 font-medium">Total Gaji Dibayar</p>
            </div>
        </div>

        <div class="card p-4 mb-6">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <input type="month" name="month" value="{{ request('month') }}" class="input-field">
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Dibayar</option>
                </select>
                <select name="department" class="input-field">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1 justify-center">Filter</button>
                    @if(request()->anyFilled(['month','status','department']))
                        <a href="{{ route('reports.payrolls') }}" class="btn-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Pegawai</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Departemen</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Periode</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-right">Gaji Pokok</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-right">Tunjangan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-right">Potongan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-right">Gaji Bersih</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($payrolls as $p)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->employee->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $p->employee->department?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $p->period }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-slate-900">Rp {{ number_format($p->base_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-emerald-600">Rp {{ number_format($p->total_allowance, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">Rp {{ number_format($p->total_deduction, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-slate-900">Rp {{ number_format($p->net_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="badge @if($p->status == 'paid') badge-success @else badge @endif">{{ ucfirst($p->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
