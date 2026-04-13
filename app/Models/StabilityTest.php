<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StabilityTest extends Model
{
    protected $fillable = [
        'product_id',
        'schedule_date',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
