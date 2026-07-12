<x-admin-layout>
    <div>
        <div class="flex items-center mb-6">
            <a href="{{ route('leave-types.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 mr-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Tipe Cuti</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $leaveType->name }}</p>
            </div>
        </div>

        <div class="card">
            <form action="{{ route('leave-types.update', $leaveType) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <x-input-label for="name" value="Nama" />
                        <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $leaveType->name)" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="code" value="Kode" />
                        <x-text-input id="code" name="code" type="text" class="block w-full" :value="old('code', $leaveType->code)" />
                        <x-input-error :messages="$errors->get('code')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label for="quota" value="Kuota (hari)" />
                        <x-text-input id="quota" name="quota" type="number" class="block w-full" :value="old('quota', $leaveType->quota)" />
                        <x-input-error :messages="$errors->get('quota')" class="mt-1" />
                    </div>
                    <div class="space-y-1.5 flex items-end pb-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input id="is_paid" name="is_paid" type="checkbox" value="1" {{ old('is_paid', $leaveType->is_paid) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-500/15 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-700">Cuti Dibayar</span>
                        </label>
                    </div>
                    <div class="md:col-span-2 space-y-1.5">
                        <x-input-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" rows="3" class="input-field">{{ old('description', $leaveType->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ route('leave-types.index') }}" class="btn-secondary">Batal</a>
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
