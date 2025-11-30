<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'code'
    ];

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    public function shippingFee()
    {
        return $this->hasMany(ShippingFee::class);
    }
}
