<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes, HasUuids;
    protected $fillable = [
        'user_id',
        'session_id',
        'order_id',
        'transaction_reference',
        'amount',
        'status',
        'link',
        'payment_method',
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
