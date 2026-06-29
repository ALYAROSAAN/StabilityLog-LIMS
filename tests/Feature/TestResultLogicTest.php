<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestResultLogicTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // tests/Feature/TestResultLogicTest.php
    public function test_anomaly_detection_logic()
    {
        // Simulasi data dengan parameter non-organoleptic
        $result = new \App\Models\TestResult([
            'value' => 25.0,
        ]);
        
        // Anda perlu melakukan mock atau membuat TestingParameter terkait
        // untuk menguji jalur logic di checkAnomaly()
        $this->assertTrue($result->checkAnomaly()); // Jika 25.0 di luar limit
    }
}
