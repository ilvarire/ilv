<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasUuids;
    protected $fillable = [
        'name',
        'slug',
        'brief',
        'description',
        'price',
        'is_active',
        'is_featured',
        'quantity',
        'weight',
        'dimensions',
        'materials',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function reviewCount()
    {
        return $this->reviews()->count();
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }
}
