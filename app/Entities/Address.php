<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'zip_code',
        'street',
        'complement',
        'neighborhood',
        'city',
        'state',
        'unit',
        'ibge_code',
        'gia_code'
    ];
}
