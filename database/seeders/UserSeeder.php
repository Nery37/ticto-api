<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::create([
            'name' => 'Gestor 1',
            'document' => '86485748032',
            'email' => 'gestor1@example.com',
            'password' => Hash::make('password'),
            'birthdate' => '1980-01-01',
            'role_id' => RoleEnum::ADMINISTRATOR->value,
            'address_id' => 1,
        ]);

        $managerSecond = User::create([
            'name' => 'Gestor 2',
            'document' => '77895134000',
            'email' => 'gestor2@example.com',
            'password' => Hash::make('password'),
            'birthdate' => '1980-01-01',
            'role_id' => RoleEnum::ADMINISTRATOR->value,
            'address_id' => 2,
        ]);

        User::create([
            'name' => 'Funcionario 1',
            'document' => '01871772010',
            'email' => 'funcionario1@example.com',
            'password' => Hash::make('password'),
            'birthdate' => '1990-01-01',
            'role_id' => RoleEnum::EMPLOYEE->value,
            'address_id' => 3,
            'manager_id' => $manager->id,
        ]);

        User::create([
            'name' => 'Funcionario 2',
            'document' => '15133014031',
            'email' => 'funcionario2@example.com',
            'password' => Hash::make('password'),
            'birthdate' => '1991-01-01',
            'role_id' => RoleEnum::EMPLOYEE->value,
            'address_id' => 3,
            'manager_id' => $managerSecond->id,
        ]);

        User::create([
            'name' => 'Funcionario 3',
            'document' => '62347812001',
            'email' => 'funcionario3@example.com',
            'password' => Hash::make('password'),
            'birthdate' => '1992-01-01',
            'role_id' => RoleEnum::EMPLOYEE->value,
            'address_id' => 4,
            'manager_id' => $manager->id,
        ]);

        User::create([
            'name' => 'Funcionario 4',
            'document' => '94285712367',
            'email' => 'funcionario4@example.com',
            'password' => Hash::make('password'),
            'birthdate' => '1993-01-01',
            'role_id' => RoleEnum::EMPLOYEE->value,
            'address_id' => 5,
            'manager_id' => $managerSecond->id,
        ]);
    }
}
