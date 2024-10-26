<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Entities\CheckInType;

class CheckInTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CheckInType::insert([
            ['name' => 'check_in', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'check_out', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
