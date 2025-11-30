<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingAddress extends Model
{
    use SoftDeletes, HasUuids;
    protected $fillable = [
        'user_id',
        'country_id',
        'shipping_fee_id',
        'address',
        'city',
        'phone_number',
        'zip_code'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function shippingFee()
    {
        return $this->belongsTo(ShippingFee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
