<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Contracts\RepositoryInterface;

class AuthService extends AppService
{
    private const TOKEN_TYPE = 'bearer';

    protected RepositoryInterface $repository;

    /**
     * @param UserRepository          $repository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(
        UserRepository $repository,
        private readonly PasswordResetRepository $passwordResetRepository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws \Exception
     */
    public function login(array $data): array
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        $token = auth('api')->attempt($credentials);

        if (empty($token)) {
            throw new \Exception('Unauthorized', 401);
        }

        return $this->getResponseToken(
            $token
        );
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function refreshToken(): array
    {
        return $this->getResponseToken(
            auth('api')->refresh()
        );
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     */
    public function forgot(array $data): void
    {
        try {
            DB::beginTransaction();
            $passwordReset = $this->passwordResetRepository
                ->skipPresenter()
                ->findWhere(['email' => $data['email']])
                ->first();

            if (empty($passwordReset) || $passwordReset->created_at->addMinutes(2) <= Carbon::now()) {
                if (!empty($reset)) {
                    $this->passwordResetRepository->delete($passwordReset->id);
                }

                $newPasswordReset = [
                    'email' => $data['email'],
                    'token' => str_replace('/', '', bcrypt($data['email']))
                ];

                $this->passwordResetRepository->skipPresenter()->create($newPasswordReset);

                DB::commit();
                return;
            }
            DB::rollBack();
            throw new \Exception('Recuperação de senha já foi solicitado com esse endereço de email!', 422);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param array $data
     */
    public function resetPassword(array $data): void
    {
        $passwordReset = $this->passwordResetRepository
            ->skipPresenter()
            ->findWhere(['token' => $data['token']])
            ->first();

        $user = $this->repository->skipPresenter()->findWhere(['email' => $passwordReset->email])->first();

        $this->repository->update(['password' => bcrypt($data['password'])], $user->id);

        $this->passwordResetRepository->delete($passwordReset->id);
    }

    private function getResponseToken($token): array
    {
        return [
            'data' => [
                'access_token' => $token,
                'token_type' => self::TOKEN_TYPE
            ]
        ];
    }

    public function changePassword(array $data): void
    {
        try {
            DB::beginTransaction();

            $user = $this->repository->skipPresenter()->find(auth('api')->user()->id);

            if (!Hash::check($data['current_password'], $user->password)) {
                throw new \Exception('A senha atual está incorreta.', 422);
            }

            $this->repository->update(['password' => Hash::make($data['new_password'])], $user->id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
