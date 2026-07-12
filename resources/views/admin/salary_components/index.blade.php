<x-admin-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Komponen Gaji</h1>
                <p class="text-sm text-slate-500 mt-1">Atur tunjangan dan potongan gaji</p>
            </div>
            <a href="{{ route('salary-components.create') }}" class="btn-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Komponen
            </a>
        </div>

        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Nama</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Kode</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tipe</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Jumlah</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Perhitungan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($salaryComponents as $component)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $component->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $component->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge {{ $component->type == 'allowance' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $component->type == 'allowance' ? 'Tunjangan' : 'Potongan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">Rp {{ number_format($component->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $component->calculation == 'fixed' ? 'Fixed' : 'Persentase' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge {{ $component->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $component->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('salary-components.edit', $component) }}" class="btn-warning px-3 py-1.5 text-xs">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada komponen gaji</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
