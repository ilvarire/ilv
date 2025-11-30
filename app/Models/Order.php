<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = [
        'user_id',
        'reference',
        'total_price',
        'status',
        'note',
        'order_type',
        'shipping_address_id',
        'coupon_id',
        'delivered_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function shippingFee()
    {
        return $this->hasOneThrough(ShippingAddress::class, ShippingAddress::class);
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, ShippingFee::class, 'id', 'id', 'id', 'country_id');
    }
}
