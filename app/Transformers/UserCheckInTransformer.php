<?php

namespace App\Transformers;

use App\Entities\UserCheckIn;
use League\Fractal\TransformerAbstract;

/**
 * Class UserCheckInTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserCheckInTransformer extends TransformerAbstract
{
    /**
     * Transform the UserCheckIn entity.
     *
     * @param UserCheckIn $model
     *
     * @return array
     */
    public function transform(UserCheckIn $model)
    {
        return [
            'id'               => (int) $model->id,
            'user'             => $model->user->only(['name', 'email']),
            'type_name'        => $model->checkInType->name ?? null,
            'created_at'       => $model->created_at ? $model->created_at->toDateTimeString() : null,
            'updated_at'       => $model->updated_at ? $model->updated_at->toDateTimeString() : null,
        ];
    }
}
