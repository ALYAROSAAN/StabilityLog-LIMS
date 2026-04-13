<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'batch_code', 'barcode_qr', 'status'];

    public function stabilityTests()
    {
        return $this->hasMany(StabilityTest::class);
    }
}
