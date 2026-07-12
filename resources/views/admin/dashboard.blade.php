<x-admin-layout>
    <div>
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan data kepegawaian {{ config('app.name', 'HRIS Gampang') }}</p>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="card hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl shadow-lg bg-gradient-to-br from-primary-500 to-primary-600 shadow-primary-500/20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Pegawai Aktif</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalActiveEmployees }}</p>
                    </div>
                </div>
            </div>
            <div class="card hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl shadow-lg bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-emerald-500/20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Departemen</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalDepartments }}</p>
                    </div>
                </div>
            </div>
            <div class="card hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl shadow-lg bg-gradient-to-br from-amber-500 to-amber-600 shadow-amber-500/20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Cuti Pending</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $pendingLeaveRequests }}</p>
                    </div>
                </div>
            </div>
            <div class="card hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl shadow-lg bg-gradient-to-br from-sky-500 to-sky-600 shadow-sky-500/20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Hadir Hari Ini</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $todayAttendance }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            {{-- Chart: Monthly Leave Stats --}}
            <div class="card p-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <h2 class="text-base font-semibold text-slate-900">Statistik Cuti (6 Bulan)</h2>
                    </div>
                </div>
                <div class="flex items-end gap-2 h-40">
                    @foreach($monthlyLeaves as $item)
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full flex flex-col items-center gap-0.5">
                                <div class="w-full rounded-t-md bg-emerald-400 transition-all hover:bg-emerald-500 cursor-pointer"
                                     style="height: {{ $item['approved'] > 0 ? max(4, ($item['approved'] / $maxMonthly) * 100) : 0 }}%"
                                     title="Disetujui: {{ $item['approved'] }}">
                                </div>
                                <div class="w-full rounded-b-md bg-red-400 transition-all hover:bg-red-500 cursor-pointer"
                                     style="height: {{ $item['rejected'] > 0 ? max(4, ($item['rejected'] / $maxMonthly) * 100) : 0 }}%"
                                     title="Ditolak: {{ $item['rejected'] }}">
                                </div>
                            </div>
                            <span class="text-[11px] font-medium text-slate-500 mt-1">{{ $item['month'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center gap-4 mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500">
                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-emerald-400"></span>
                        Disetujui
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-red-400"></span>
                        Ditolak
                    </div>
                </div>
            </div>

            {{-- Employee by Department --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <h2 class="text-base font-semibold text-slate-900">Pegawai per Departemen</h2>
                </div>
                <div class="space-y-4">
                    @forelse($employeesByDepartment as $dept)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-700 font-medium truncate">{{ $dept->name }}</span>
                                <span class="text-slate-500 flex-shrink-0 ml-2">{{ $dept->employees_count }} org</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full transition-all duration-500"
                                     style="width: {{ $totalActiveEmployees > 0 ? ($dept->employees_count / $totalActiveEmployees) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 text-center py-4">Belum ada data</p>
                    @endforelse
                </div>
                @if($employeesByDepartment->isNotEmpty())
                    <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-400 text-center">
                        Total {{ $totalActiveEmployees }} pegawai aktif
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Recent Pending Leave Requests --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <h2 class="text-base font-semibold text-slate-900">Pengajuan Cuti Terbaru</h2>
                    </div>
                    <a href="{{ route('leave-requests.index') }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentLeaves as $lr)
                        <a href="{{ route('leave-requests.show', $lr) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 text-xs font-bold text-amber-700 flex-shrink-0">
                                {{ substr($lr->employee->full_name ?? '?', 0, 1) }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate group-hover:text-primary-600 transition-colors">{{ $lr->employee->full_name ?? '-' }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $lr->leaveType->name }} &middot; {{ $lr->days }} hari</p>
                            </div>
                            <span class="badge badge-warning text-[11px] flex-shrink-0">Pending</span>
                        </a>
                    @empty
                        <div class="text-center py-8">
                            <svg class="h-10 w-10 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-slate-500">Tidak ada pengajuan pending</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Today's Attendance Breakdown --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h2 class="text-base font-semibold text-slate-900">Kehadiran Hari Ini</h2>
                    <span class="text-xs text-slate-400 ml-auto">{{ now()->isoFormat('D MMM YYYY') }}</span>
                </div>
                @php
                    $totalAttendanceToday = $todayAttendances->count();
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-4">
                    <div class="bg-emerald-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-emerald-600">{{ $attendanceHadir }}</p>
                        <p class="text-[11px] text-emerald-500 font-medium">Hadir</p>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-amber-600">{{ $attendanceTerlambat }}</p>
                        <p class="text-[11px] text-amber-500 font-medium">Terlambat</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-blue-600">{{ $attendanceIzin }}</p>
                        <p class="text-[11px] text-blue-500 font-medium">Izin</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-purple-600">{{ $attendanceSakit }}</p>
                        <p class="text-[11px] text-purple-500 font-medium">Sakit</p>
                    </div>
                    <div class="bg-red-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-red-600">{{ $attendanceAbsen }}</p>
                        <p class="text-[11px] text-red-500 font-medium">Absen</p>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden flex">
                    @php
                        $colors = ['bg-emerald-500', 'bg-amber-500', 'bg-blue-500', 'bg-purple-500', 'bg-red-500'];
                        $values = [$attendanceHadir, $attendanceTerlambat, $attendanceIzin, $attendanceSakit, $attendanceAbsen];
                        $total = max(array_sum($values), 1);
                    @endphp
                    @foreach($values as $i => $v)
                        @if($v > 0)
                            <div class="{{ $colors[$i] }} h-full transition-all" style="width: {{ ($v / $total) * 100 }}%"></div>
                        @endif
                    @endforeach
                </div>
                <a href="{{ route('attendances.index') }}" class="block mt-4 text-center text-xs font-medium text-primary-600 hover:text-primary-700">Lihat Detail Kehadiran</a>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="mt-8">
            <div class="card p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('employees.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100">
                            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Tambah Pegawai</p>
                            <p class="text-xs text-slate-500">Register pegawai baru</p>
                        </div>
                    </a>
                    <a href="{{ route('leave-requests.index') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                            <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Kelola Cuti</p>
                            <p class="text-xs text-slate-500">{{ $pendingLeaveRequests }} pengajuan pending</p>
                        </div>
                    </a>
                    <a href="{{ route('attendances.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Input Absensi</p>
                            <p class="text-xs text-slate-500">Catat kehadiran pegawai</p>
                        </div>
                    </a>
                    <a href="{{ route('payrolls.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100">
                            <svg class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Buat Payroll</p>
                            <p class="text-xs text-slate-500">Generate penggajian bulanan</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
