<x-admin-layout>
    <div>
        <div class="flex items-center mb-6">
            <a href="{{ route('salary-components.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 mr-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Komponen Gaji</h1>
                <p class="text-sm text-slate-500 mt-0.5">Tambah tunjangan atau potongan baru</p>
            </div>
        </div>

        <div class="card">
            <form action="{{ route('salary-components.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <x-input-label for="name" value="Nama" />
                        <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="code" value="Kode" />
                        <x-text-input id="code" name="code" type="text" class="block w-full" :value="old('code')" />
                        <x-input-error :messages="$errors->get('code')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="type" value="Tipe" />
                        <select id="type" name="type" class="input-field">
                            <option value="allowance" {{ old('type') == 'allowance' ? 'selected' : '' }}>Tunjangan</option>
                            <option value="deduction" {{ old('type') == 'deduction' ? 'selected' : '' }}>Potongan</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="amount" value="Jumlah (Rp)" />
                        <x-text-input id="amount" name="amount" type="number" class="block w-full" :value="old('amount')" />
                        <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="calculation" value="Perhitungan" />
                        <select id="calculation" name="calculation" class="input-field">
                            <option value="fixed" {{ old('calculation') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percentage" {{ old('calculation') == 'percentage' ? 'selected' : '' }}>Persentase</option>
                        </select>
                        <x-input-error :messages="$errors->get('calculation')" class="mt-1" />
                    </div>
                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" rows="3" class="input-field">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ route('salary-components.index') }}" class="btn-secondary">Batal</a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
