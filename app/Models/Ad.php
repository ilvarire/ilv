<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'main_text',
        'sub_text',
        'image_url',
        'link',
        'text_color'
    ];
}
