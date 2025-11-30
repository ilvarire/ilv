<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'story_one',
        'story_two',
        'mission_one',
        'story_image',
        'mission_two',
        'mission_image',
    ];
}
