<x-employee-layout>
    <div class="mb-6">
        <a href="{{ route('employee.leave-requests.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card p-6">
        <h2 class="text-xl font-semibold text-slate-900 mb-6">Ajukan Cuti</h2>
        <form action="{{ route('employee.leave-requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <x-input-label for="leave_type_id" value="Tipe Cuti" />
                    <select id="leave_type_id" name="leave_type_id" class="input-field">
                        <option value="">Pilih Tipe Cuti</option>
                        @foreach($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->id }}" {{ old('leave_type_id') == $leaveType->id ? 'selected' : '' }} {{ $leaveType->remaining == 0 ? 'disabled' : '' }}>
                                {{ $leaveType->name }} ({{ $leaveType->remaining }}/{{ $leaveType->quota }} hari){{ $leaveType->remaining == 0 ? ' - Habis' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('leave_type_id')" class="mt-1" />
                </div>
                <div class="space-y-1.5">
                    <x-input-label for="supporting_document" value="Dokumen Pendukung (opsional)" />
                    <input id="supporting_document" name="supporting_document" type="file" class="input-field file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <p class="text-xs text-slate-400 mt-1">Format: PDF, JPG, PNG. Maksimal 1MB.</p>
                    <x-input-error :messages="$errors->get('supporting_document')" class="mt-1" />
                </div>
                <div class="space-y-1.5">
                    <x-input-label for="start_date" value="Tanggal Mulai" />
                    <x-text-input id="start_date" name="start_date" type="date" class="block w-full" :value="old('start_date')" />
                    <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
                </div>
                <div class="space-y-1.5">
                    <x-input-label for="end_date" value="Tanggal Selesai" />
                    <x-text-input id="end_date" name="end_date" type="date" class="block w-full" :value="old('end_date')" />
                    <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
                </div>
                <div class="md:col-span-2 space-y-1.5">
                    <x-input-label for="reason" value="Alasan" />
                    <textarea id="reason" name="reason" rows="3" class="input-field">{{ old('reason') }}</textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                <a href="{{ route('employee.leave-requests.index') }}" class="btn-secondary">Batal</a>
                <x-primary-button>Ajukan</x-primary-button>
            </div>
        </form>
    </div>
</x-employee-layout>
