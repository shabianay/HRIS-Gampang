<x-employee-layout>
    <div>
        <div class="mb-6">
            <a href="{{ route('employee.attendances.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="card p-6 sm:p-8">
            {{-- Header Summary --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-6 border-b border-slate-200">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Detail Kehadiran</h2>
                    <p class="text-slate-500 mt-1">{{ $attendance->date->format('l, d F Y') }}</p>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="badge text-sm px-4 py-2
                        @if($attendance->status == 'hadir') badge-success
                        @elseif($attendance->status == 'terlambat') badge-warning
                        @elseif($attendance->status == 'izin' || $attendance->status == 'sakit') badge-info
                        @else badge-danger
                        @endif">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 mb-8">
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Terlambat</p>
                    <p class="text-lg font-bold text-slate-900 mt-1">{{ $attendance->late_minutes ? $attendance->late_minutes . ' menit' : '-' }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">IP Address</p>
                    <p class="text-sm font-medium text-slate-900 mt-1 font-mono truncate">{{ $attendance->ip_address ?? '-' }}</p>
                </div>
            </div>

            {{-- Clock In & Clock Out Sections --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Clock In Card --}}
                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-emerald-800">Clock In</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Waktu</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i:s') : '-' }}</p>
                        </div>

                        @if($attendance->clock_in_latitude && $attendance->clock_in_longitude)
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lokasi GPS</p>
                            <p class="text-sm text-slate-700 mt-1 font-mono">{{ number_format($attendance->clock_in_latitude, 6) }}, {{ number_format($attendance->clock_in_longitude, 6) }}</p>
                            <a href="https://www.google.com/maps?q={{ $attendance->clock_in_latitude }},{{ $attendance->clock_in_longitude }}" target="_blank" class="text-xs text-emerald-600 hover:text-emerald-700 mt-1 inline-flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Buka di Google Maps
                            </a>
                        </div>
                        @else
                        <div class="text-slate-400 text-sm">Lokasi GPS tidak tersedia</div>
                        @endif
                    </div>

                        @if($attendance->photo_in)
                        <div class="mt-6 pt-6 border-t border-emerald-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Foto Selfie</p>
                            <img src="{{ asset('storage/' . $attendance->photo_in) }}" alt="Selfie Clock In" class="w-full max-w-md h-64 object-cover rounded-xl border border-emerald-100 shadow-md">
                        </div>
                        @endif
                </div>

                {{-- Clock Out Card --}}
                <div class="bg-red-50 border border-red-100 rounded-2xl p-6 {{ !$attendance->clock_out ? 'opacity-50' : '' }}">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-red-800">Clock Out</h3>
                        @if(!$attendance->clock_out)
                            <span class="badge badge-warning ml-auto text-xs">Belum Clock Out</span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Waktu</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i:s') : '-' }}</p>
                        </div>

                        @if($attendance->clock_out_latitude && $attendance->clock_out_longitude)
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lokasi GPS</p>
                            <p class="text-sm text-slate-700 mt-1 font-mono">{{ number_format($attendance->clock_out_latitude, 6) }}, {{ number_format($attendance->clock_out_longitude, 6) }}</p>
                            <a href="https://www.google.com/maps?q={{ $attendance->clock_out_latitude }},{{ $attendance->clock_out_longitude }}" target="_blank" class="text-xs text-red-600 hover:text-red-700 mt-1 inline-flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Buka di Google Maps
                            </a>
                        </div>
                        @else
                        <div class="text-slate-400 text-sm">Lokasi GPS tidak tersedia</div>
                        @endif
                    </div>

                        @if($attendance->photo_out)
                        <div class="mt-6 pt-6 border-t border-red-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Foto Selfie</p>
                            <img src="{{ asset('storage/' . $attendance->photo_out) }}" alt="Selfie Clock Out" class="w-full max-w-md h-64 object-cover rounded-xl border border-red-100 shadow-md">
                        </div>
                        @elseif($attendance->clock_out)
                        <div class="mt-6 pt-6 border-t border-red-100 text-slate-400 text-sm text-center py-4">
                            Tidak ada foto selfie clock out
                        </div>
                        @endif
                </div>
            </div>

            {{-- Notes --}}
            @if($attendance->notes)
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h3 class="text-lg font-bold text-slate-900">Keterangan</h3>
                </div>
                <p class="text-sm text-slate-700 bg-white p-4 rounded-xl border border-slate-200">{{ $attendance->notes }}</p>
            </div>
            @endif

            {{-- Perangkat / Browser --}}
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <h3 class="text-lg font-bold text-slate-900">Perangkat / Browser</h3>
                </div>
                <p class="text-sm text-slate-700 bg-white p-4 rounded-xl border border-slate-200 break-words font-mono text-xs">{{ $attendance->device_info ?? 'Tidak tersedia' }}</p>
            </div>
        </div>
    </div>
</x-employee-layout>
