<?php

namespace App\Modules\Product\Services;

use App\Models\Product;
use App\Models\StabilityTest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class RegisterProductAction
{
    public function execute(array $data): bool
    {
        // 1. Generate QR Code
        $qrPath = 'qrcodes/' . $data['batch_code'] . '.svg';
        QrCode::format('svg')->generate(
            $data['batch_code'],
            public_path($qrPath)
        );

        // 2. Create Product dengan status 'Ready for Testing'
        $product = Product::create([
            'name'       => $data['name'],
            'batch_code' => $data['batch_code'],
            'barcode_qr' => $qrPath,
            'status'     => 'Ready for Testing',
        ]);

        // 3. Otomatisasi Jadwal Uji pada H+1, H+7, dan H+30
        $intervals = [1, 7, 30];
        foreach ($intervals as $day) {
            StabilityTest::create([
                'product_id'    => $product->id,
                'schedule_date' => Carbon::now()->addDays($day),
                'status'        => 'Scheduled',
            ]);
        }

        return true;
    }
}