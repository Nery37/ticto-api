<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController.
 */
class AuthController extends Controller
{
    protected $service;

    /**
     * @param AuthService $service
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->service->login($request->validated()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $this->service->logout();

            return $this->successResponse([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        try {
            return $this->successResponse($this->service->refreshToken());
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param ForgotPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->service->forgot($request->validated());
            return $this->successResponse(['data' => ['message' => 'Reset de senha enviado!']]);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->service->resetPassword($request->validated());
            return $this->successResponse(['data' => ['message' => 'Senha atualizada com sucesso!']]);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $this->service->changePassword($request->validated());
            return $this->successResponse(['data' => ['message' => 'Senha alterada com sucesso!']]);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }
}
