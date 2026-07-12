<x-employee-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kehadiran Mandiri</h1>
                <p class="text-sm text-slate-500 mt-1">Catat kehadiran Anda hari ini</p>
            </div>
            <div class="flex items-center gap-3">
                @if(!$todayAttendance)
                    <form action="{{ route('employee.attendances.clockIn') }}" method="POST" id="clockInForm">
                        @csrf
                        <input type="hidden" name="latitude" id="latIn">
                        <input type="hidden" name="longitude" id="lngIn">
                        <button type="button" onclick="getLocation('clockInForm', 'latIn', 'lngIn')" class="btn-primary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Clock In
                        </button>
                    </form>
                @elseif(!$todayAttendance->clock_out)
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                            Clock In: {{ $todayAttendance->clock_in->format('H:i') }}
                        </span>
                        <form action="{{ route('employee.attendances.clockOut') }}" method="POST" id="clockOutForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="latitude" id="latOut">
                            <input type="hidden" name="longitude" id="lngOut">
                            <button type="button" onclick="getLocation('clockOutForm', 'latOut', 'lngOut')" class="btn-danger">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Clock Out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2 text-sm font-medium text-slate-600 bg-slate-100 px-4 py-2 rounded-xl">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Absensi Hari Ini Selesai
                    </div>
                @endif
            </div>

    <script>
        function getLocation(formId, latId, lngId) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        document.getElementById(latId).value = position.coords.latitude;
                        document.getElementById(lngId).value = position.coords.longitude;
                        document.getElementById(formId).submit();
                    },
                    (error) => {
                        alert("Lokasi diperlukan untuk absensi. Mohon izinkan akses lokasi.");
                        document.getElementById(formId).submit();
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser Anda.");
                document.getElementById(formId).submit();
            }
        }
    </script>

        </div>

        <div class="grid grid-cols-5 gap-3 mb-6">
            <div class="bg-emerald-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600">{{ $summary['hadir'] }}</p>
                <p class="text-xs text-emerald-500 font-medium">Hadir</p>
            </div>
            <div class="bg-amber-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ $summary['terlambat'] }}</p>
                <p class="text-xs text-amber-500 font-medium">Terlambat</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $summary['absen'] }}</p>
                <p class="text-xs text-red-500 font-medium">Absen</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $summary['izin'] }}</p>
                <p class="text-xs text-blue-500 font-medium">Izin</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-purple-600">{{ $summary['sakit'] }}</p>
                <p class="text-xs text-purple-500 font-medium">Sakit</p>
            </div>
        </div>

        <div class="card p-4 mb-6">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-field">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-field">
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="absen" {{ request('status') == 'absen' ? 'selected' : '' }}>Absen</option>
                    <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1 justify-center">Filter</button>
                    @if(request('date_from') || request('date_to') || request('status'))
                        <a href="{{ route('employee.attendances.index') }}" class="btn-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tanggal</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock In</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock Out</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Terlambat</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">IP / Lokasi</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $attendance->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge
                                        @if($attendance->status == 'hadir') badge-success
                                        @elseif($attendance->status == 'terlambat') badge-warning
                                        @elseif($attendance->status == 'izin' || $attendance->status == 'sakit') badge-info
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->late_minutes ? $attendance->late_minutes . ' menit' : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-xs">{{ $attendance->ip_address ?? '-' }}</span>
                                        @if($attendance->latitude && $attendance->longitude)
                                            <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="text-[10px] text-primary-600 hover:text-primary-700">
                                                {{ number_format($attendance->latitude, 4) }}, {{ number_format($attendance->longitude, 4) }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm text-slate-500">Belum ada data kehadiran</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>
</x-employee-layout>
