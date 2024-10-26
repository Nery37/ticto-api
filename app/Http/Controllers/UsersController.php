<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * Class UsersController.
 */
class UsersController extends Controller
{
    protected $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function storeUser(UserCreateRequest $request): JsonResponse
    {
        try {
            return $this->successCreatedResponse($this->service->storeUser($request->validated()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    public function updateUser(UserUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return $this->successResponse($this->service->updateUser($request->validated(), $id));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    public function userInfo(): JsonResponse
    {
        try {
            return $this->successWithOrWithoutContentResponse($this->service->userInfo());
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }
}
