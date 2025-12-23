<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'base_price',
        'cost_price',
        'weight',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper methods
    public function getTotalStock(): int
    {
        return $this->variants()->sum('stock');
    }

    public function hasLowStock(): bool
    {
        return $this->variants()
            ->where('is_available', true)
            ->where('stock', '<=', 'min_stock')
            ->exists();
    }

    public function isInStock(): bool
    {
        return $this->getTotalStock() > 0;
    }

    public function getLowestPrice(): float
    {
        return $this->variants()
            ->where('is_available', true)
            ->min('price') ?? $this->base_price;
    }

    public function getHighestPrice(): float
    {
        return $this->variants()
            ->where('is_available', true)
            ->max('price') ?? $this->base_price;
    }
}