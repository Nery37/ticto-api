<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AddressService
{
    private const VIACEP_BASE_URL = 'https://viacep.com.br/ws';

    /**
     * @param string $zipCode
     * @return array
     * @throws \Exception
     */
    public function fetchAddressByZipcode(string $zipCode): array
    {
        $cleanZipCode = preg_replace('/\D/', '', $zipCode);
        $response = Http::get(self::VIACEP_BASE_URL . "/{$cleanZipCode}/json/");

        if ($response->failed() || $response->json('erro')) {
            throw new \Exception('Invalid or nonexistent zip code.');
        }

        return $response->json();
    }
}
