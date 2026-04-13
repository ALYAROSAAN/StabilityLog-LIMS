<?php

namespace App\Modules\Product\Services;

use App\Models\Product;
use App\Models\StabilityTest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RegisterProductAction
{
    /**
     * Eksekusi pendaftaran produk dengan otomatisasi jadwal dan QR generation
     *
     * @param array $data Data produk (name, batch_code)
     * @return bool True jika berhasil
     */
    public function execute(array $data): bool
    {
        try {
            // 1. Generate QR Code dengan format SVG unik per batch
            $qrFileName = $data['batch_code'] . '.svg';
            $qrPath = 'qrcodes/' . $qrFileName;
            
            // Pastikan folder qrcodes ada
            if (!is_dir(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }

            // Generate QR Code berisi link ke detail batch
            QrCode::format('svg')
                ->size(300)
                ->generate(
                    route('products.show', $data['batch_code']),
                    public_path($qrPath)
                );

            // 2. Buat Product dengan status "Ready for Testing"
            $product = Product::create([
                'name'       => $data['name'],
                'batch_code' => $data['batch_code'],
                'qr_code'    => $qrPath,
                'status'     => 'Ready',
            ]);

            // 3. Otomatisasi Jadwal Uji Stabilitas (H+1, H+7, H+30)
            $scheduleIntervals = [1, 7, 30];
            
            foreach ($scheduleIntervals as $days) {
                StabilityTest::create([
                    'product_id'    => $product->id,
                    'schedule_date' => Carbon::now()->addDays($days),
                    'status'        => 'Scheduled',
                ]);
            }

            // Log erfolg pendaftaran
            Log::info('Product registered successfully', [
                'product_id' => $product->id,
                'batch_code' => $data['batch_code'],
                'schedules_created' => count($scheduleIntervals),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Product registration failed', [
                'batch_code' => $data['batch_code'],
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
}