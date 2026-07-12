<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin HR',
            'email' => 'admin@hris.com',
            'password' => 'password',
            'role' => 'admin_hr',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Pegawai 1',
            'email' => 'pegawai@hris.com',
            'password' => 'password',
            'role' => 'pegawai',
            'is_active' => true,
        ]);
    }
}
