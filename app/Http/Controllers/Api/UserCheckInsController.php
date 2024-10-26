<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserCheckInService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserCheckInsController.
 *
 * @package namespace App\Http\Controllers;
 */
class UserCheckInsController extends Controller
{
    protected $service;

    /**
     * @param UserCheckInService $service
     */
    public function __construct(UserCheckInService $service)
    {
        $this->service = $service;
    }

    public function storeCheckIn(): JsonResponse
    {
        try {
            return $this->successCreatedResponse(
                $this->service->createCheckIn()
            );
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    public function indexSubordinateCheckIns(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $page = (int) $request->query('page', 1);
            $perPage = (int) $request->query('per_page', 10);

            $data = $this->service->getSubordinatesCheckIns($startDate, $endDate, $page, $perPage);

            return $this->successWithOrWithoutContentResponse($data);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    public function getUserCheckInsToday(): JsonResponse
    {
        try {
            $data = $this->service->getUserCheckInsToday();
            return $this->successWithOrWithoutContentResponse($data);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error fetching today\'s check-ins', 'error' => $exception->getMessage()], 500);
        }
    }
}
