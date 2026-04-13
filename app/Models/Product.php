<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * Attributes yang dapat diisi mass assignment
     */
    protected $fillable = [
        'name',
        'batch_code',
        'qr_code',
        'status',
    ];

    /**
     * Casting untuk tipe data yang konsisten
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke StabilityTest (1 Product memiliki banyak StabilityTest)
     */
    public function stabilityTests(): HasMany
    {
        return $this->hasMany(StabilityTest::class);
    }
}
