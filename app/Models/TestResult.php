<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    protected $table = 'test_results';

    protected $fillable = [
        'stability_test_id',
        'testing_parameter_id',
        'value',
        'is_anomaly',
    ];

    protected $casts = [
        'value' => 'double',
        'is_anomaly' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $result) {
            $result->is_anomaly = $result->computeIsAnomaly();
        });
    }

    public function stabilityTest(): BelongsTo
    {
        return $this->belongsTo(StabilityTest::class);
    }

    public function testingParameter(): BelongsTo
    {
        return $this->belongsTo(TestingParameter::class);
    }

    public function computeIsAnomaly(): bool
    {
        if ($this->value === null || $this->testingParameter === null) {
            return false;
        }

        return $this->value < $this->testingParameter->min_limit
            || $this->value > $this->testingParameter->max_limit;
    }
}