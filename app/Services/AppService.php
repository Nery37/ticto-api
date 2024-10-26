<?php

declare(strict_types=1);

namespace App\Services;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AppService.
 */
class AppService
{
    protected RepositoryInterface $repository;

    /**
     * @param int $limit
     *
     * @return mixed
     */
    public function all(int $limit = 15): mixed
    {
        return $this->repository->paginate($limit);
    }

    public function allWithoutPagination(): mixed
    {
        return $this->repository->all();
    }

    /**
     * @param array $data
     * @param bool  $skipPresenter
     *
     * @return mixed
     */
    public function create(array $data, bool $skipPresenter = false): mixed
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($skipPresenter) {
            return $this->repository->skipPresenter()->create($data);
        }

        return $this->repository->create($data);
    }

    /**
     * @param int  $id
     * @param bool $skipPresenter
     *
     * @return mixed
     */
    public function find(int|string $id, bool $skipPresenter = false): mixed
    {
        if ($skipPresenter) {
            return $this->repository->skipPresenter()->find($id);
        }

        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @param       $id
     * @param bool  $skipPresenter
     *
     * @return array|mixed
     */
    public function update(array $data, $id, bool $skipPresenter = false): mixed
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($skipPresenter) {
            return $this->repository->skipPresenter()->update($data, $id);
        }

        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     *
     * @return bool[]
     */
    public function delete($id): array
    {
        return ['success' => (bool) $this->repository->delete($id)];
    }

    /**
     * @param string $uuid
     * @param bool   $skipPresenter
     *
     * @return mixed
     */
    public function findByUuid(string $uuid, bool $skipPresenter = false): mixed
    {
        if ($skipPresenter) {
            return $this->repository->skipPresenter()->findByUuid($uuid);
        }
        return $this->repository->findByUuid($uuid);
    }

    /**
     * @param array  $data
     * @param string $uuid
     * @param bool   $skipPresenter
     *
     * @return array|mixed
     */
    public function updateByUuid(array $data, string $uuid, bool $skipPresenter = false): mixed
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($skipPresenter) {
            return $this->repository->skipPresenter()->updateByUuid($data, $uuid);
        }

        return $this->repository->updateByUuid($data, $uuid);
    }

    /**
     * @param string $uuid
     *
     * @return bool[]
     */
    public function deleteByUuid(string $uuid): array
    {
        return ['success' => (bool) $this->repository->deleteByUuid($uuid)];
    }
}
