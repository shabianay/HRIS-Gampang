<x-admin-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen Pegawai</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data seluruh pegawai</p>
            </div>
            <a href="{{ route('employees.create') }}" class="btn-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pegawai
            </a>
        </div>

        {{-- Filter Card --}}
        <div class="card p-4 sm:p-5 mb-6">
            <form method="GET" action="{{ route('employees.index') }}">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="Cari NIK atau Nama..." value="{{ request('search') }}" class="input-field pl-10">
                    </div>
                    <select name="department" class="input-field">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="input-field">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="cuti" {{ request('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="resign" {{ request('status') == 'resign' ? 'selected' : '' }}>Resign</option>
                    </select>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="btn-primary flex-1 justify-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari
                        </button>
                        @if(request('search') || request('department') || request('status'))
                            <a href="{{ route('employees.index') }}" class="btn-secondary flex-1 justify-center">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Table Card --}}
        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">NIK</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Nama</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Departemen</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Jabatan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $employee->nik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    <a href="{{ route('employees.show', $employee) }}" class="text-primary-600 hover:text-primary-700 font-medium">{{ $employee->full_name }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $employee->department?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $employee->position?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge
                                        @if($employee->status == 'aktif') badge-success
                                        @elseif($employee->status == 'cuti') badge-warning
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('employees.show', $employee) }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">Detail</a>
                                        <a href="{{ route('employees.edit', $employee) }}" class="btn-warning px-3 py-1.5 text-xs">Edit</a>
                                        <form id="deactivate-employee-{{ $employee->id }}" action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="$store.confirm.open('Nonaktifkan pegawai ini?', 'deactivate-employee-{{ $employee->id }}', { confirmText: 'Ya, Nonaktifkan' })" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">Nonaktifkan</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada data pegawai</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($employees->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $employees->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
