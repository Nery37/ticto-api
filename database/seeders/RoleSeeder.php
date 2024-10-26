<?php

namespace Database\Seeders;

use App\Entities\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'Funcionário', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
