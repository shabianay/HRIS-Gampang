<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Jabatan</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola jabatan/posisi di perusahaan</p>
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
            <h3 class="text-base font-semibold text-slate-900 mb-4">Tambah Jabatan</h3>
            <form action="{{ route('settings.positions.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                    <input type="text" name="name" placeholder="Nama Jabatan" value="{{ old('name') }}" class="input-field">
                    <input type="text" name="code" placeholder="Kode" value="{{ old('code') }}" class="input-field">
                    <input type="text" name="level" placeholder="Level" value="{{ old('level') }}" class="input-field">
                    <input type="text" name="description" placeholder="Deskripsi" value="{{ old('description') }}" class="input-field sm:col-span-1">
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
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Nama Jabatan</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Kode</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Level</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Deskripsi</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Pegawai</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100" x-data="{ editing: null }">
                        @forelse($positions as $position)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    <span x-show="editing !== {{ $position->id }}">{{ $position->name }}</span>
                                    <input x-show="editing === {{ $position->id }}" type="text" form="edit-{{ $position->id }}" name="name" value="{{ $position->name }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <span x-show="editing !== {{ $position->id }}">{{ $position->code }}</span>
                                    <input x-show="editing === {{ $position->id }}" type="text" form="edit-{{ $position->id }}" name="code" value="{{ $position->code }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <span x-show="editing !== {{ $position->id }}">{{ $position->level }}</span>
                                    <input x-show="editing === {{ $position->id }}" type="text" form="edit-{{ $position->id }}" name="level" value="{{ $position->level }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">
                                    <span x-show="editing !== {{ $position->id }}">{{ $position->description ?? '-' }}</span>
                                    <input x-show="editing === {{ $position->id }}" type="text" form="edit-{{ $position->id }}" name="description" value="{{ $position->description }}" class="input-field py-2 text-sm">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $position->employees_count ?? $position->employees()->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <button x-show="editing !== {{ $position->id }}" @click="editing = {{ $position->id }}" class="btn-warning px-3 py-1.5 text-xs">Edit</button>
                                        <span x-show="editing === {{ $position->id }}" class="flex items-center gap-2">
                                            <button type="button" @click="$store.confirm.open('Simpan perubahan jabatan ini?', 'edit-{{ $position->id }}', { confirmText: 'Ya, Simpan', type: 'warning' })" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors">Simpan</button>
                                            <button @click="editing = null" class="btn-secondary px-3 py-1.5 text-xs">Batal</button>
                                        </span>
                                        <form id="delete-position-{{ $position->id }}" action="{{ route('settings.positions.destroy', $position) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="$store.confirm.open('Hapus jabatan ini?', 'delete-position-{{ $position->id }}')" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                    <form id="edit-{{ $position->id }}" action="{{ route('settings.positions.update', $position) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p class="text-sm text-slate-500">Tidak ada jabatan</p>
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
