<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'address',
        'phone_number',
        'email',
        'facebook_link',
        'tiktok_link',
        'instagram_link',
        'whatsapp_link'
    ];
}
