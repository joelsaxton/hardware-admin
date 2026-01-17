<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'brand_id',
        'price',
        'stock',
        'sku',
        'weight',
    ];

    protected $casts = [
        'stock' => 'integer',
        'weight' => 'float',
    ];

    /**
     * @return Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => sprintf('%.2f', $value / 100),
            set: fn (string|float $value) => (int) round(floatval($value) * 100),
        );
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
