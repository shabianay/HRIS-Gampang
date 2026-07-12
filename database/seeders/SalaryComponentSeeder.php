<?php

namespace Database\Seeders;

use App\Models\SalaryComponent;
use Illuminate\Database\Seeder;

class SalaryComponentSeeder extends Seeder
{
    public function run(): void
    {
        SalaryComponent::create([
            'name' => 'Gaji Pokok',
            'code' => 'GP',
            'type' => 'allowance',
            'amount' => 5000000,
            'calculation' => 'fixed',
            'is_active' => true,
            'description' => 'Gaji pokok karyawan',
        ]);

        SalaryComponent::create([
            'name' => 'Tunjangan Makan',
            'code' => 'TM',
            'type' => 'allowance',
            'amount' => 500000,
            'calculation' => 'fixed',
            'is_active' => true,
            'description' => 'Tunjangan makan harian',
        ]);

        SalaryComponent::create([
            'name' => 'Tunjangan Transportasi',
            'code' => 'TT',
            'type' => 'allowance',
            'amount' => 300000,
            'calculation' => 'fixed',
            'is_active' => true,
            'description' => 'Tunjangan transportasi bulanan',
        ]);

        SalaryComponent::create([
            'name' => 'BPJS Kesehatan',
            'code' => 'BPJSKES',
            'type' => 'deduction',
            'amount' => 1,
            'calculation' => 'percentage',
            'is_active' => true,
            'description' => 'Potongan BPJS Kesehatan',
        ]);

        SalaryComponent::create([
            'name' => 'BPJS Ketenagakerjaan',
            'code' => 'BPJSKT',
            'type' => 'deduction',
            'amount' => 2,
            'calculation' => 'percentage',
            'is_active' => true,
            'description' => 'Potongan BPJS Ketenagakerjaan',
        ]);

        SalaryComponent::create([
            'name' => 'Potongan Terlambat',
            'code' => 'LATE',
            'type' => 'deduction',
            'amount' => 50000,
            'calculation' => 'fixed',
            'is_active' => true,
            'description' => 'Potongan keterlambatan per hari',
        ]);
    }
}
