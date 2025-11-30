<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    protected $fillable = [
        'admin',
        'subject',
        'message',
        'receivers',
        'number',
        'image_url'
    ];
}
