<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_featured',
        'image_url'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean'
        ];
    }
}
