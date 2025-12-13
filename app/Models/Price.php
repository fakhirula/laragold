<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'price_type',
        'price_per_gram',
        'recorded_at',
    ];

    protected $casts = [
        'price_per_gram' => 'decimal:6',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the product for this price
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
