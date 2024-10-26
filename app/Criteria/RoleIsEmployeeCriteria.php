<?php

declare(strict_types=1);

namespace App\Criteria;

use App\Enums\RoleEnum;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RoleIsEmployeeCriteria.
 */
class RoleIsEmployeeCriteria implements CriteriaInterface
{
    /**
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model->where('role_id', RoleEnum::EMPLOYEE->value);
    }
}
