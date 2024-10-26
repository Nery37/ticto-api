<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCheckIn extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'check_in_type_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkInType()
    {
        return $this->belongsTo(CheckInType::class);
    }
}
