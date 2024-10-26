<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Entities\PasswordReset;
use League\Fractal\TransformerAbstract;

/**
 * Class PasswordResetTransformer.
 */
class PasswordResetTransformer extends TransformerAbstract
{
    /**
     * Transform the PasswordReset entity.
     *
     * @param PasswordReset $model
     *
     * @return array
     */
    public function transform(PasswordReset $model): array
    {
        return [
            'email' => $model->email,
            'token' => $model->token,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString()
        ];
    }
}
