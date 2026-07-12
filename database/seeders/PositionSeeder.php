<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        Position::create([
            'name' => 'Staff',
            'code' => 'STF',
            'level' => 1,
            'description' => 'Staff level position',
        ]);

        Position::create([
            'name' => 'Senior Staff',
            'code' => 'SSTF',
            'level' => 2,
            'description' => 'Senior Staff level position',
        ]);

        Position::create([
            'name' => 'Supervisor',
            'code' => 'SPV',
            'level' => 3,
            'description' => 'Supervisor level position',
        ]);

        Position::create([
            'name' => 'Manager',
            'code' => 'MGR',
            'level' => 4,
            'description' => 'Manager level position',
        ]);

        Position::create([
            'name' => 'Direktur',
            'code' => 'DIR',
            'level' => 5,
            'description' => 'Direktur level position',
        ]);
    }
}
