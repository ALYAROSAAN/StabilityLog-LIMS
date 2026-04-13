<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StabilityTest extends Model
{
    /**
     * Attributes yang dapat diisi mass assignment
     */
    protected $fillable = [
        'product_id',
        'schedule_date',
        'status',
    ];

    /**
     * Casting untuk tipe data yang konsisten
     */
    protected $casts = [
        'schedule_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Product (banyak StabilityTest memiliki satu Product)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi 1:1 ke TestResult
     */
    public function testResult(): HasOne
    {
        return $this->hasOne(TestResult::class);
    }
}
