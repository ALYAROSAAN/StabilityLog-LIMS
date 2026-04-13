<?php

namespace App\Observers;

use App\Models\AuditTrail;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TestResultObserver
{
    public function created(TestResult $result): void
    {
        AuditTrail::create([
            'user_id' => Auth::id(),
            'auditable_type' => 'test_result',
            'auditable_id' => $result->id,
            'event' => 'created',
            'old_values' => null,
            'new_values' => $result->getAttributes(),
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public function updated(TestResult $result): void
    {
        $changes = $result->getChanges();

        if (empty($changes)) {
            return;
        }

        AuditTrail::create([
            'user_id' => Auth::id(),
            'auditable_type' => 'test_result',
            'auditable_id' => $result->id,
            'event' => 'updated',
            'old_values' => $result->getOriginal(),
            'new_values' => $result->getAttributes(),
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
