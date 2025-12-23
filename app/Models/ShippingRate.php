<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'city', 'province', 'rate_per_kg', 'is_active'
    ];

    protected $casts = [
        'rate_per_kg' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
