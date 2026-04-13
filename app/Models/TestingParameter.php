<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestingParameter extends Model
{
    protected $fillable = [
        'product_id',
        'param_name',
        'min_limit',
        'max_limit',
    ];

    protected $casts = [
        'min_limit' => 'double',
        'max_limit' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $parameter) {
            if (strtolower($parameter->param_name) === 'ph') {
                if ($parameter->min_limit !== null && ($parameter->min_limit < 0.0 || $parameter->min_limit > 14.0)) {
                    throw new \InvalidArgumentException('Nilai pH minimum harus berada di antara 0.0 dan 14.0.');
                }
                if ($parameter->max_limit !== null && ($parameter->max_limit < 0.0 || $parameter->max_limit > 14.0)) {
                    throw new \InvalidArgumentException('Nilai pH maksimum harus berada di antara 0.0 dan 14.0.');
                }
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}