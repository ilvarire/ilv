<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $fillable = [
        'maintenance',
        'policy',
        'site_description',
        'site_title',
        'top_text',
        'og_image',
        'favicon',
        'logo'
    ];
    protected $hidden = [
        'maintenance'
    ];

    protected function casts(): array
    {
        return [
            'maintenance' => 'boolean'
        ];
    }
}
