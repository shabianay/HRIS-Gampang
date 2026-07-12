<x-admin-layout>
    <div>
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $employee->full_name }}</h1>
                    <p class="text-sm text-slate-500 mt-0.5">NIK: {{ $employee->nik }}</p>
                </div>
            </div>
            <a href="{{ route('employees.edit', $employee) }}" class="btn-warning">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Personal Info Card --}}
            <div class="card">
                <h3 class="text-base font-semibold text-slate-900 mb-4 border-b border-slate-200 pb-3">Informasi Pribadi</h3>
                <dl class="space-y-3.5">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">NIK</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->nik }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Nama Lengkap</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->full_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Jenis Kelamin</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Tempat, Tanggal Lahir</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->birth_place ? $employee->birth_place . ', ' : '' }}{{ $employee->birth_date ? $employee->birth_date->format('d M Y') : '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">No. Telepon</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Alamat</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->address ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">User</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->user?->email ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Employment Info Card --}}
            <div class="card">
                <h3 class="text-base font-semibold text-slate-900 mb-4 border-b border-slate-200 pb-3">Informasi Kepegawaian</h3>
                <dl class="space-y-3.5">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Departemen</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->department?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Jabatan</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->position?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Tanggal Bergabung</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->join_date ? $employee->join_date->format('d M Y') : '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Status</dt>
                        <dd>
                            <span class="badge
                                @if($employee->status == 'aktif') badge-success
                                @elseif($employee->status == 'cuti') badge-warning
                                @else badge-danger
                                @endif">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>

                <h3 class="text-base font-semibold text-slate-900 mt-6 mb-4 border-b border-slate-200 pb-3">Perbankan & Pajak</h3>
                <dl class="space-y-3.5">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Bank</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->bank_name ? $employee->bank_name . ' - ' . $employee->bank_account . ' (' . $employee->bank_account_name . ')' : '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">NPWP</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->npwp ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">BPJS Kesehatan</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->bpjs_kesehatan ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">BPJS Ketenagakerjaan</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->bpjs_ketenagakerjaan ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-slate-500">Catatan</dt>
                        <dd class="text-sm text-slate-900 font-medium">{{ $employee->notes ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($employee->leaveRequests->count() > 0)
            <div class="card mt-5">
                <h3 class="text-base font-semibold text-slate-900 mb-4 border-b border-slate-200 pb-3">Riwayat Pengajuan Cuti</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3 text-left">Tipe</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3 text-left">Tanggal Mulai</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3 text-left">Tanggal Selesai</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3 text-left">Status</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach($employee->leaveRequests as $leave)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900">{{ $leave->leaveType?->name ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">{{ $leave->start_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">{{ $leave->end_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="badge
                                            @if($leave->status == 'approved') badge-success
                                            @elseif($leave->status == 'pending') badge-warning
                                            @else badge-danger
                                            @endif">
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-500">{{ $leave->reason ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
