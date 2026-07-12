<x-admin-layout>
    <div>
        <div class="mb-6">
            <a href="{{ route('payrolls.show', $payroll) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="card p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Edit Payroll</h2>
            <form action="{{ route('payrolls.update', $payroll) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="label">Pegawai</label>
                        <select name="employee_id" class="input-field">
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('employee_id', $payroll->employee_id) == $emp->id ? 'selected' : '' }}>{{ $emp->full_name }} ({{ $emp->nik }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('employee_id')" />
                    </div>
                    <div>
                        <label class="label">Periode</label>
                        <input type="month" name="period" value="{{ old('period', $payroll->period) }}" class="input-field">
                        <x-input-error :messages="$errors->get('period')" />
                    </div>
                    <div>
                        <label class="label">Gaji Pokok</label>
                        <input type="number" name="base_salary" value="{{ old('base_salary', $payroll->base_salary) }}" class="input-field">
                        <x-input-error :messages="$errors->get('base_salary')" />
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-base font-semibold text-slate-900 mb-4">Komponen Gaji</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @php
                            $selectedIds = collect(array_merge(array_keys($payroll->details['allowances'] ?? []), array_keys($payroll->details['deductions'] ?? [])));
                            $allowanceCodes = \App\Models\SalaryComponent::where('type', 'allowance')->pluck('code', 'id');
                            $deductionCodes = \App\Models\SalaryComponent::where('type', 'deduction')->pluck('code', 'id');
                            $allCodes = $allowanceCodes->merge($deductionCodes);
                        @endphp
                        @foreach($salaryComponents as $component)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-primary-300 cursor-pointer transition-all">
                                <input type="checkbox" name="salary_components[]" value="{{ $component->id }}"
                                    {{ in_array($component->id, old('salary_components', $payroll->details ? array_merge(array_keys($payroll->details['allowances'] ?? []), array_keys($payroll->details['deductions'] ?? [])) : [])) ? 'checked' : '' }}
                                    class="rounded text-primary-600 focus:ring-primary-500">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $component->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $component->type === 'allowance' ? 'Tunjangan' : 'Potongan' }} {{ $component->calculation === 'percentage' ? '(' . $component->amount . '%)' : '(Rp ' . number_format($component->amount, 0, ',', '.') . ')' }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-3">
                    <x-primary-button>Simpan Perubahan</x-primary-button>
                    <a href="{{ route('payrolls.show', $payroll) }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
