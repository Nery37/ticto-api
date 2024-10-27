<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

/**
 * Class UserTransformer.
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'document' => $model->document,
            'role' => $model->role,
            'birthdate' => $model->birthdate->format('Y-m-d'),
            'age' => Carbon::parse($model->birthdate)->age,
            'address' => $model->address,
            'manager_name' => $model->manager->name ?? null,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString()
        ];
    }
}
