<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use Illuminate\Http\JsonResponse;

/**
 * Class AddressController.
 */
class AddressController extends Controller
{
    protected $service;

    /**
    * @param AddressService $service
    */
    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $zipCode
     * @return JsonResponse
     */
    public function getAddressByZipCode(string $zipCode): JsonResponse
    {
        try {
            $data = $this->service->fetchAddressByZipcode($zipCode);
            return $this->successResponse(['data' => $data]);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao buscar o endereço.', 'error' => $exception->getMessage()], 500);
        }
    }
}
