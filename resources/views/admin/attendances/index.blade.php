<x-admin-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kehadiran</h1>
                <p class="text-sm text-slate-500 mt-1">Monitor kehadiran pegawai</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('attendances.create') }}" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Input Manual
                </a>
                <a href="{{ route('attendances.export', request()->query()) }}" class="btn-secondary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </a>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="card p-4 sm:p-5 mb-6">
            <form method="GET" action="{{ route('attendances.index') }}">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-field">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-field">
                    <select name="department" class="input-field">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="input-field">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="absen" {{ request('status') == 'absen' ? 'selected' : '' }}>Absen</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                    <div class="flex items-end gap-2 sm:col-span-4">
                        <button type="submit" class="btn-primary justify-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </button>
                        @if(request('date_from') || request('date_to') || request('department') || request('status'))
                            <a href="{{ route('attendances.index') }}" class="btn-secondary justify-center">Reset</a>
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
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tanggal</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock In</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock Out</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Terlambat</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">IP Address</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Lokasi GPS</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Perangkat</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $attendance->employee->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge
                                        @if($attendance->status == 'hadir') badge-success
                                        @elseif($attendance->status == 'terlambat') badge-warning
                                        @elseif($attendance->status == 'izin' || $attendance->status == 'sakit') badge
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->late_minutes ? $attendance->late_minutes . ' menit' : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->ip_address ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    @if($attendance->latitude && $attendance->longitude)
                                        <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="text-primary-600 hover:text-primary-700 underline" title="Buka di Google Maps">
                                            {{ number_format($attendance->latitude, 4) }}, {{ number_format($attendance->longitude, 4) }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 max-w-[150px] truncate" title="{{ $attendance->device_info ?? '-' }}">
                                    {{ $attendance->device_info ? \Illuminate\Support\Str::limit($attendance->device_info, 30) : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada data kehadiran</p>
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
</x-admin-layout>
