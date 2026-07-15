<?php

namespace Database\Seeders;

use App\Models\PayrollSetting;
use Illuminate\Database\Seeder;

class PayrollSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // BPJS Kesehatan
            ['key' => 'bpjs_kesehatan_employee_rate', 'value' => '1'],
            ['key' => 'bpjs_kesehatan_employer_rate', 'value' => '4'],
            ['key' => 'bpjs_kesehatan_max_base', 'value' => '12000000'],
            // BPJS Ketenagakerjaan - JHT
            ['key' => 'bpjs_jht_employee_rate', 'value' => '2'],
            ['key' => 'bpjs_jht_employer_rate', 'value' => '3.7'],
            // BPJS Ketenagakerjaan - JP
            ['key' => 'bpjs_jp_employee_rate', 'value' => '1'],
            ['key' => 'bpjs_jp_employer_rate', 'value' => '2'],
            // BPJS Ketenagakerjaan - JKK & JKM (employer only)
            ['key' => 'bpjs_jkk_rate', 'value' => '0.54'],
            ['key' => 'bpjs_jkm_rate', 'value' => '0.3'],
            // PTKP values (per year)
            ['key' => 'ptkp_tk0', 'value' => '54000000'],
            ['key' => 'ptkp_tk1', 'value' => '58500000'],
            ['key' => 'ptkp_tk2', 'value' => '63000000'],
            ['key' => 'ptkp_tk3', 'value' => '67500000'],
            ['key' => 'ptkp_k0', 'value' => '58500000'],
            ['key' => 'ptkp_k1', 'value' => '63000000'],
            ['key' => 'ptkp_k2', 'value' => '67500000'],
            ['key' => 'ptkp_k3', 'value' => '72000000'],
        ];

        foreach ($settings as $setting) {
            PayrollSetting::create($setting);
        }
    }
}
