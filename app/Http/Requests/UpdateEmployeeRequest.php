<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik' => [
                'required', 'string', 'max:20',
                Rule::unique('employees', 'nik')->ignore($this->route('employee')),
            ],
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_place' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'join_date' => 'required|date',
            'status' => 'required|in:aktif,nonaktif,resign,cuti',
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:20',
            'bpjs_kesehatan' => 'nullable|string|max:20',
            'bpjs_ketenagakerjaan' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ];
    }
}
