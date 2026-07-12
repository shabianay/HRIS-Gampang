<x-employee-layout>
    <div>
        <div class="mb-6">
            <a href="{{ route('employee.attendances.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-900">Detail Kehadiran</h2>
                <span class="badge text-sm px-4 py-2
                    @if($attendance->status == 'hadir') badge-success
                    @elseif($attendance->status == 'terlambat') badge-warning
                    @elseif($attendance->status == 'izin' || $attendance->status == 'sakit') badge-info
                    @else badge-danger
                    @endif">
                    {{ ucfirst($attendance->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</p>
                    <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $attendance->date->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Clock In</p>
                    <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i:s') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Clock Out</p>
                    <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i:s') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Terlambat</p>
                    <p class="text-sm font-medium text-slate-900 mt-0.5">{{ $attendance->late_minutes ? $attendance->late_minutes . ' menit' : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">IP Address</p>
                    <p class="text-sm font-medium text-slate-900 mt-0.5 font-mono">{{ $attendance->ip_address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lokasi GPS Clock In</p>
                    @if($attendance->clock_in_latitude && $attendance->clock_in_longitude)
                        <p class="text-sm font-medium text-slate-900 mt-0.5">
                            {{ number_format($attendance->clock_in_latitude, 6) }}, {{ number_format($attendance->clock_in_longitude, 6) }}
                        </p>
                        <a href="https://www.google.com/maps?q={{ $attendance->clock_in_latitude }},{{ $attendance->clock_in_longitude }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-700 mt-1 inline-flex items-center gap-1">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Buka di Google Maps
                        </a>
                    @else
                        <p class="text-sm font-medium text-slate-400 mt-0.5">Tidak tersedia</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lokasi GPS Clock Out</p>
                    @if($attendance->clock_out_latitude && $attendance->clock_out_longitude)
                        <p class="text-sm font-medium text-slate-900 mt-0.5">
                            {{ number_format($attendance->clock_out_latitude, 6) }}, {{ number_format($attendance->clock_out_longitude, 6) }}
                        </p>
                        <a href="https://www.google.com/maps?q={{ $attendance->clock_out_latitude }},{{ $attendance->clock_out_longitude }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-700 mt-1 inline-flex items-center gap-1">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Buka di Google Maps
                        </a>
                    @else
                        <p class="text-sm font-medium text-slate-400 mt-0.5">Tidak tersedia</p>
                    @endif
                </div>
            </div>

            @if($attendance->notes)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Keterangan</p>
                    <p class="text-sm text-slate-900 bg-slate-50 p-3 rounded-xl border border-slate-200">{{ $attendance->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-employee-layout>
