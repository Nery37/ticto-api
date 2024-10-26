<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckInType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
}
