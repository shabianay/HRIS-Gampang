<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Departemen</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola departemen di perusahaan</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-medium">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Add Form Card --}}
        <div class="card p-4 sm:p-5 mb-6">
            <h3 class="text-base font-semibold text-slate-900 mb-4">Tambah Departemen</h3>
            <form action="{{ route('settings.departments.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <input type="text" name="name" placeholder="Nama Departemen" value="{{ old('name') }}" class="input-field">
                    <input type="text" name="code" placeholder="Kode" value="{{ old('code') }}" class="input-field">
                    <input type="text" name="description" placeholder="Deskripsi" value="{{ old('description') }}" class="input-field">
                    <x-primary-button class="justify-center">Simpan</x-primary-button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Nama Departemen</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Kode</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Deskripsi</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Pegawai</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100" x-data="{ editing: null }">
                        @forelse($departments as $department)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    <span x-show="editing !== {{ $department->id }}">{{ $department->name }}</span>
                                    <input x-show="editing === {{ $department->id }}" type="text" form="edit-{{ $department->id }}" name="name" value="{{ $department->name }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <span x-show="editing !== {{ $department->id }}">{{ $department->code }}</span>
                                    <input x-show="editing === {{ $department->id }}" type="text" form="edit-{{ $department->id }}" name="code" value="{{ $department->code }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">
                                    <span x-show="editing !== {{ $department->id }}">{{ $department->description ?? '-' }}</span>
                                    <input x-show="editing === {{ $department->id }}" type="text" form="edit-{{ $department->id }}" name="description" value="{{ $department->description }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $department->employees_count ?? $department->employees()->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <button x-show="editing !== {{ $department->id }}" @click="editing = {{ $department->id }}" class="btn-warning px-3 py-1.5 text-xs">Edit</button>
                                        <span x-show="editing === {{ $department->id }}" class="flex items-center gap-2">
                                            <button type="button" @click="$store.confirm.open('Simpan perubahan departemen ini?', 'edit-{{ $department->id }}', { confirmText: 'Ya, Simpan', type: 'warning' })" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors">Simpan</button>
                                            <button @click="editing = null" class="btn-secondary px-3 py-1.5 text-xs">Batal</button>
                                        </span>
                                        <form id="delete-department-{{ $department->id }}" action="{{ route('settings.departments.destroy', $department) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="$store.confirm.open('Hapus departemen ini?', 'delete-department-{{ $department->id }}')" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                    <form id="edit-{{ $department->id }}" action="{{ route('settings.departments.update', $department) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada departemen</p>
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
