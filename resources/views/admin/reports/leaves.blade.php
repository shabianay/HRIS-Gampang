<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Laporan Cuti</h1>
            <p class="text-sm text-slate-500 mt-1">Rekap pengajuan cuti pegawai</p>
        </div>

        <div class="grid grid-cols-5 gap-3 mb-6">
            <div class="bg-emerald-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600">{{ $summary['approved'] }}</p>
                <p class="text-xs text-emerald-500 font-medium">Disetujui</p>
            </div>
            <div class="bg-amber-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ $summary['pending'] }}</p>
                <p class="text-xs text-amber-500 font-medium">Pending</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $summary['rejected'] }}</p>
                <p class="text-xs text-red-500 font-medium">Ditolak</p>
            </div>
            <div class="bg-slate-100 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-slate-600">{{ $summary['cancelled'] }}</p>
                <p class="text-xs text-slate-500 font-medium">Dibatalkan</p>
            </div>
            <div class="bg-primary-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-primary-600">{{ $summary['total_days'] }}</p>
                <p class="text-xs text-primary-500 font-medium">Total Hari</p>
            </div>
        </div>

        <div class="card p-4 mb-6">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <select name="department" class="input-field">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="input-field" placeholder="Dari">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="input-field" placeholder="Sampai">
                <div class="flex gap-2 sm:col-span-4">
                    <button type="submit" class="btn-primary justify-center">Filter</button>
                    @if(request()->anyFilled(['status','department','start_date','end_date']))
                        <a href="{{ route('reports.leaves') }}" class="btn-secondary">Reset</a>
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
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tipe Cuti</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tanggal</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Hari</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($leaves as $lr)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $lr->employee->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $lr->leaveType->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $lr->start_date->format('d/m/Y') }} - {{ $lr->end_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $lr->days }} hari</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="badge @if($lr->status == 'approved') badge-success @elseif($lr->status == 'pending') badge-warning @elseif($lr->status == 'cancelled') badge-secondary @else badge-danger @endif">{{ ucfirst($lr->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
