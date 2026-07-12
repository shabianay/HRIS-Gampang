<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Pengajuan Cuti</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola pengajuan cuti pegawai</p>
        </div>

        {{-- Filter Card --}}
        <div class="card p-4 sm:p-5 mb-6">
            <form method="GET" action="{{ route('leave-requests.index') }}">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <select name="status" class="input-field">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <select name="department" class="input-field">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="btn-primary flex-1 justify-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </button>
                        @if(request('status') || request('department'))
                            <a href="{{ route('leave-requests.index') }}" class="btn-secondary flex-1 justify-center">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Pegawai</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Departemen</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tipe Cuti</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tanggal</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Durasi</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($leaveRequests as $leaveRequest)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $leaveRequest->employee->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $leaveRequest->employee->department?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $leaveRequest->leaveType->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} hari</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge
                                        @if($leaveRequest->status == 'pending') badge-warning
                                        @elseif($leaveRequest->status == 'approved') badge-success
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($leaveRequest->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('leave-requests.show', $leaveRequest) }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">Detail</a>
                                        @if($leaveRequest->status == 'pending')
                                            <form action="{{ route('leave-requests.approve', $leaveRequest) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors">Approve</button>
                                            </form>
                                            <form id="reject-leave-{{ $leaveRequest->id }}" action="{{ route('leave-requests.reject', $leaveRequest) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" @click="$store.confirm.open('Tolak pengajuan cuti ini?', 'reject-leave-{{ $leaveRequest->id }}', { confirmText: 'Ya, Tolak', type: 'warning' })" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada pengajuan cuti</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($leaveRequests->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
