<x-employee-layout>
    <div class="card">
        <h2 class="text-xl font-semibold text-slate-900 mb-6">Riwayat Penggajian Saya</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Periode</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Gaji Pokok</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Tunjangan</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Potongan</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Gaji Bersih</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Status</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($payrolls as $payroll)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $payroll->period }}</td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('employee.payrolls.show', $payroll) }}" class="text-primary-600 hover:text-primary-700">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-sm text-slate-500">Belum ada data penggajian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payrolls->hasPages())
            <div class="mt-4 border-t border-slate-200 pt-4">
                {{ $payrolls->links() }}
            </div>
        @endif
    </div>
</x-employee-layout>
