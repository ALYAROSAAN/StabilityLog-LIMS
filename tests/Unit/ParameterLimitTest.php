<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ParameterLimitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_within_range_logic()
    {
        $limit = new \App\Models\ParameterLimit([
            'min_value' => 10.0,
            'max_value' => 20.0
        ]);

        // Jalur: Nilai di dalam rentang
        $this->assertTrue($limit->isWithinRange(15.0));
        
        // Jalur: Nilai di luar rentang (terlalu rendah)
        $this->assertFalse($limit->isWithinRange(5.0));
        
        // Jalur: Nilai null
        $this->assertFalse($limit->isWithinRange(null));
    }
}
