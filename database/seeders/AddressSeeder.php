<?php

namespace Database\Seeders;

use App\Entities\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::insert([
            [
                'zip_code' => '01001000',
                'street' => 'Praça da Sé',
                'complement' => 'Lado ímpar',
                'neighborhood' => 'Sé',
                'city' => 'São Paulo',
                'state' => 'SP',
                'unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zip_code' => '20040002',
                'street' => 'Rua da Assembleia',
                'complement' => 'Apto 202',
                'neighborhood' => 'Centro',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
                'unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zip_code' => '30120000',
                'street' => 'Av. Afonso Pena',
                'complement' => 'Bloco B',
                'neighborhood' => 'Centro',
                'city' => 'Belo Horizonte',
                'state' => 'MG',
                'unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zip_code' => '40010000',
                'street' => 'Praça Castro Alves',
                'complement' => 'Próximo ao teatro',
                'neighborhood' => 'Centro',
                'city' => 'Salvador',
                'state' => 'BA',
                'unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zip_code' => '60025100',
                'street' => 'Av. Beira Mar',
                'complement' => 'Orla marítima',
                'neighborhood' => 'Meireles',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
