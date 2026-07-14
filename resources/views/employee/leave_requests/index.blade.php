<x-employee-layout>
    <div class="card mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Pengajuan Cuti Saya</h2>
                <p class="mt-0.5 text-sm text-slate-500">Riwayat & unduh slip gaji bulanan Anda.</p>
            </div>
            <a href="{{ route('employee.leave-requests.create') }}" class="btn-primary text-xs">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajukan Cuti
            </a>
        </div>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">
                            Tipe Cuti</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">
                            Tanggal</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">
                            Durasi</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">
                            Status</th>
                        <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3 text-left">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($leaveRequests as $lr)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $lr->leaveType->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ \Carbon\Carbon::parse($lr->start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($lr->end_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $lr->days }} hari</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="badge
                                    @if ($lr->status == 'pending') badge-warning
                                    @elseif($lr->status == 'approved') badge-success
                                    @elseif($lr->status == 'cancelled') badge-secondary
                                    @else badge-danger @endif">
                                    {{ ucfirst($lr->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('employee.leave-requests.show', $lr) }}"
                                        class="text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">Detail</a>
                                    @if ($lr->status == 'pending')
                                        <form action="{{ route('employee.leave-requests.cancel', $lr) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors"
                                                onclick="return confirm('Yakin ingin membatalkan pengajuan cuti ini?')">Batal</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-slate-500">Belum ada pengajuan cuti</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($leaveRequests->hasPages())
            <div class="mt-4 border-t border-slate-200 pt-4">
                {{ $leaveRequests->links() }}
            </div>
        @endif
    </div>
</x-employee-layout>
