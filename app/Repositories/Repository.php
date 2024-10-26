<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class Repository extends BaseRepository
{
    /**
     * @param array  $data
     * @param string $uuid
     *
     * @return Collection|LengthAwarePaginator|mixed
     *
     * @throws ValidatorException
     */
    public function updateByUuid(array $data, string $uuid): mixed
    {
        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter();

        $model = $this->model::query()->where('uuid', '=', $uuid)->firstOrFail();

        $this->skipPresenter($temporarySkipPresenter);

        return $this->update($data, $model->id);
    }

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public function findByUuid(string $uuid): mixed
    {
        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter();

        $result = $this->model::query()->where('uuid', '=', $uuid)->firstOrFail();

        $this->skipPresenter($temporarySkipPresenter);

        return $this->parserResult($result);
    }

    /**
     * @param string $uuid
     *
     * @return int
     */
    public function deleteByUuid(string $uuid): int
    {
        $model = $this->model::query()->where('uuid', '=', $uuid)->firstOrFail();

        return (int) $this->delete($model->id);
    }
}
