<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Laporan Kehadiran</h1>
            <p class="text-sm text-slate-500 mt-1">Rekap data kehadiran pegawai</p>
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
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
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
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1 justify-center">Filter</button>
                    @if(request()->anyFilled(['date_from','date_to','department','status']))
                        <a href="{{ route('reports.attendances') }}" class="btn-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Pegawai</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Departemen</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tanggal</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock In</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock Out</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Terlambat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($attendances as $a)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $a->employee->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $a->employee->department?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $a->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $a->clock_in ? $a->clock_in->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $a->clock_out ? $a->clock_out->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="badge @if($a->status == 'hadir') badge-success @elseif($a->status == 'terlambat') badge-warning @elseif(in_array($a->status, ['izin','sakit'])) badge-info @else badge-danger @endif">{{ ucfirst($a->status) }}</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $a->late_minutes ? $a->late_minutes . ' menit' : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
