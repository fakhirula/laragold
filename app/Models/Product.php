<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'purity_pct',
        'weight_g',
        'is_physical',
        'is_active',
    ];

    protected $casts = [
        'is_physical' => 'boolean',
        'is_active' => 'boolean',
        'purity_pct' => 'decimal:2',
        'weight_g' => 'decimal:3',
    ];

    /**
     * Get the brand for this product
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Get all prices for this product
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    /**
     * Get the latest buy price
     */
    public function latestBuyPrice()
    {
        return $this->hasOne(Price::class)
            ->where('price_type', 'buy')
            ->orderByDesc('recorded_at')
            ->limit(1);
    }

    /**
     * Get the latest sell price
     */
    public function latestSellPrice()
    {
        return $this->hasOne(Price::class)
            ->where('price_type', 'sell')
            ->orderByDesc('recorded_at')
            ->limit(1);
    }
}
