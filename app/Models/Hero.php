<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'heading',
        'main_text',
        'link',
        'text_color',
        'image_url'
    ];
}
