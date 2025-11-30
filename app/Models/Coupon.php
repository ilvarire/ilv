<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'code',
        'discount_percentage',
        'start_date',
        'end_date'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
