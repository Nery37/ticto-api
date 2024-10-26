<?php

declare(strict_types=1);

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TodayCheckInsForUserCriteria.
 */
class TodayCheckInsForUserCriteria implements CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        $userId = auth('api')->id();
        $today = Carbon::today()->toDateString();

        return $model->where('user_id', $userId)
                     ->whereDate('created_at', $today);
    }
}
