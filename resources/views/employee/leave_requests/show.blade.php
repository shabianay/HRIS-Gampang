<x-employee-layout>
    <div class="mb-6">
        <a href="{{ route('employee.leave-requests.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card p-6">
        <h2 class="text-xl font-semibold text-slate-900 mb-6">Detail Pengajuan Cuti</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-slate-500">Tipe Cuti</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $leaveRequest->leaveType->name }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Rentang Tanggal</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Durasi</p>
                <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $leaveRequest->days }} hari</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Status</p>
                <span class="badge mt-0.5
                    @if($leaveRequest->status == 'pending') badge-warning
                    @elseif($leaveRequest->status == 'approved') badge-success
                    @else badge-danger
                    @endif">
                    {{ ucfirst($leaveRequest->status) }}
                </span>
            </div>
        </div>
        @if($leaveRequest->reason)
            <div class="mt-6">
                <p class="text-sm text-slate-500 mb-2">Alasan</p>
                <p class="text-sm text-slate-900 bg-slate-50 p-4 rounded-xl">{{ $leaveRequest->reason }}</p>
            </div>
        @endif
        @if($leaveRequest->supporting_document)
            <div class="mt-6">
                <p class="text-sm text-slate-500 mb-2">Dokumen Pendukung</p>
                <a href="{{ asset('storage/' . $leaveRequest->supporting_document) }}" target="_blank" class="btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Lihat Dokumen
                </a>
            </div>
        @endif
    </div>
</x-employee-layout>
