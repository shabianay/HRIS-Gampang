<x-employee-layout>
    <div class="space-y-8">
        {{-- Header --}}
        <div class="card p-6 sm:p-8">
            <div class="flex items-center gap-5">
                <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg shadow-primary-500/20 text-xl font-bold text-white">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </span>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-bold text-slate-900">Selamat datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $employee->department?->name ?? '-' }} &middot; {{ $employee->position?->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                        <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $pendingLeaves }}</p>
                        <p class="text-xs text-slate-500">Pengajuan Pending</p>
                    </div>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $approvedLeaves }}</p>
                        <p class="text-xs text-slate-500">Cuti Disetujui</p>
                    </div>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $thisMonthAttendance }}</p>
                        <p class="text-xs text-slate-500">Kehadiran Bulan Ini</p>
                    </div>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100">
                        <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $latestPayroll ? 'Rp ' . number_format($latestPayroll->net_salary, 0, ',', '.') : '-' }}</p>
                        <p class="text-xs text-slate-500">Gaji Terakhir</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Leave Quotas --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <h2 class="text-base font-semibold text-slate-900">Sisa Kuota Cuti {{ now()->year }}</h2>
                </div>
                <div class="space-y-3">
                    @forelse($leaveQuotas as $quota)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-700 font-medium">{{ $quota->name }}</span>
                                <span class="text-slate-500">{{ $quota->used }}/{{ $quota->quota }} hari</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full transition-all" style="width: {{ $quota->quota > 0 ? min(100, ($quota->used / $quota->quota) * 100) : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">Sisa: {{ $quota->remaining }} hari</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Tidak ada data kuota cuti</p>
                    @endforelse
                </div>
            </div>

            {{-- Today Attendance --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h2 class="text-base font-semibold text-slate-900">Kehadiran Hari Ini</h2>
                </div>
                @if($todayAttendance)
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-slate-500 uppercase tracking-wider">Clock In</p>
                            <p class="text-lg font-bold text-slate-900 mt-1">{{ $todayAttendance->clock_in ? Carbon\Carbon::parse($todayAttendance->clock_in)->format('H:i') : '-' }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-slate-500 uppercase tracking-wider">Clock Out</p>
                            <p class="text-lg font-bold text-slate-900 mt-1">{{ $todayAttendance->clock_out ? Carbon\Carbon::parse($todayAttendance->clock_out)->format('H:i') : '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <span class="badge
                            @if($todayAttendance->status == 'hadir') badge-success
                            @elseif($todayAttendance->status == 'terlambat') badge-warning
                            @elseif($todayAttendance->status == 'izin' || $todayAttendance->status == 'sakit') badge
                            @else badge-danger
                            @endif">
                            {{ ucfirst($todayAttendance->status) }}
                        </span>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="h-10 w-10 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-slate-500">Belum ada data kehadiran hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('employee.leave-requests.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100">
                        <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Ajukan Cuti</p>
                        <p class="text-xs text-slate-500">Buat pengajuan cuti baru</p>
                    </div>
                </a>
                <a href="{{ route('employee.leave-requests.index') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                        <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Cuti Saya</p>
                        <p class="text-xs text-slate-500">Lihat riwayat pengajuan cuti</p>
                    </div>
                </a>
                <a href="{{ route('employee.payrolls.index') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Penggajian</p>
                        <p class="text-xs text-slate-500">Lihat slip gaji terbaru</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-employee-layout>
