<?php

declare(strict_types=1);

namespace App\Services;

use App\Criteria\RoleIsEmployeeCriteria;
use App\Entities\User;
use App\Enums\RoleEnum;
use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * UserService.
 */
class UserService extends AppService
{
    protected RepositoryInterface $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(
        UserRepository $repository,
        private readonly AddressRepository $addressRepository
    ) {
        $this->repository = $repository;
    }

    public function all(int $limit = 15, bool $paginate = true, string $sortBy = 'id', string $sortDir = 'asc'): mixed
    {
        $queryBuilder = $this->repository
            ->resetCriteria()
            ->pushCriteria(app(RoleIsEmployeeCriteria::class))
            ->pushCriteria(app(RequestCriteria::class));

        if (!empty($sortBy) && in_array(strtolower($sortDir), ['asc', 'desc'])) {
            $queryBuilder->orderBy($sortBy, $sortDir);
        }

        if ($paginate) {
            return $queryBuilder->paginate($limit);
        }
        return $queryBuilder->all();
    }

    public function storeUser(array $data): array
    {
        try {
            DB::beginTransaction();

            $address = $this->addressRepository->create($data['address']);
            $data['address_id'] = $address->id;

            $data['manager_id'] = auth('api')->id();
            $data['role_id'] = RoleEnum::EMPLOYEE->value;

            $user = $this->create($data, true);

            DB::commit();
            return ['data' => (new UserTransformer())->transform($user)];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function updateUser(array $data, int $id): array
    {
        try {
            DB::beginTransaction();

            if (isset($data['address'])) {
                $user = $this->find($id, true);
                $address = $user->address;
                $this->addressRepository->update($data['address'], $address->id);
            }

            $user = $this->update($data, $id, true);

            DB::commit();

            return ['data' => (new UserTransformer())->transform($user)];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function userInfo(): mixed
    {
        return ['data' => (new UserTransformer())->transform(auth('api')->user())];
    }
}
