<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingFee extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'country_id',
        'state',
        'slug',
        'base_fee',
        'fee_per_kg'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
