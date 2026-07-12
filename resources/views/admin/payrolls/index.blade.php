<x-admin-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Penggajian</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola payroll pegawai</p>
            </div>
            <a href="{{ route('payrolls.create') }}" class="btn-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Payroll
            </a>
        </div>

        {{-- Filter Card --}}
        <div class="card p-4 sm:p-5 mb-6">
            <form method="GET" action="{{ route('payrolls.index') }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="month" name="period" value="{{ request('period') }}" class="input-field">
                    <div class="flex items-end gap-2">
                        <button type="submit" class="btn-primary justify-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </button>
                        @if(request('period'))
                            <a href="{{ route('payrolls.index') }}" class="btn-secondary justify-center">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="card p-0 overflow-hidden" x-data="{ selected: [] }">
            {{-- Bulk Action Bar --}}
            <div class="px-6 py-3 border-b border-slate-200 bg-slate-50 flex items-center gap-4" x-show="selected.length > 0" x-cloak>
                <span class="text-sm text-slate-600" x-text="selected.length + ' payroll dipilih'"></span>
                <button type="button" @click="$store.confirm.open('Tandai ' + selected.length + ' payroll sebagai dibayar?', 'bulk-paid-form', { confirmText: 'Ya, Bayar Semua', type: 'warning' })" class="btn-success text-sm px-4 py-1.5">
                    Mark as Paid
                </button>
                <button type="button" @click="selected = []" class="text-sm text-slate-500 hover:text-slate-700 font-medium">Batal</button>
            </div>

            <div class="overflow-x-auto">
                <form id="bulk-paid-form" action="{{ route('payrolls.bulk-paid') }}" method="POST">
                    @csrf
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                </form>

                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 w-10">
                                <input type="checkbox" @click="let checked = $event.target.checked; document.querySelectorAll('.payroll-checkbox').forEach(cb => cb.checked = checked); selected = checked ? Array.from(document.querySelectorAll('.payroll-checkbox')).map(cb => cb.value) : []"
                                       class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            </th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Pegawai</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Departemen</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Periode</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Gaji Pokok</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tunjangan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Potongan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Gaji Bersih</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($payrolls as $payroll)
                            <tr class="hover:bg-slate-50/50 transition-colors" x-data="{ checked: false }">
                                <td class="px-6 py-4">
                                    @if($payroll->status != 'paid')
                                        <input type="checkbox" value="{{ $payroll->id }}"
                                               x-model="selected"
                                               class="payroll-checkbox rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $payroll->employee->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $payroll->employee->department?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $payroll->period }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">Rp {{ number_format($payroll->total_allowance, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge
                                        @if($payroll->status == 'draft') badge
                                        @elseif($payroll->status == 'processed') badge-warning
                                        @else badge-success
                                        @endif">
                                        {{ ucfirst($payroll->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('payrolls.show', $payroll) }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">Detail</a>
                                        @if($payroll->status != 'paid')
                                            <form id="mark-paid-{{ $payroll->id }}" action="{{ route('payrolls.mark-paid', $payroll) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" @click="$store.confirm.open('Tandai payroll ' + '{{ $payroll->employee->full_name }}' + ' sebagai dibayar?', 'mark-paid-{{ $payroll->id }}', { confirmText: 'Ya, Bayar', type: 'warning' })" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors">Mark as Paid</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada data penggajian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($payrolls->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $payrolls->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
