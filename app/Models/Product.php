<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    //

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = floatval(str_replace(',', '.', $value));
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(float $value) => number_format($value, 2, ',', '.'),
            set: fn(string $value) => floatval(str_replace(',', '.', $value)),
        );
    }
}
