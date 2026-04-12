<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StabilityTest;
use Carbon\Carbon;

class ProductController extends Controller {
    public function store(Request $request) {
        // Validasi sesuai rules [cite: 174, 371]
        $request->validate([
            'name' => 'required',
            'batch_code' => 'required|unique:products,batch_code',
        ]);

        // 1. Simpan Produk
        $product = Product::create($request->all());

        // 2. Otomatisasi Jadwal H+1, H+7, H+30 [cite: 101, 196]
        $intervals = [1, 7, 30];
        foreach ($intervals as $days) {
            StabilityTest::create([
                'product_id' => $product->id,
                'schedule_date' => Carbon::now()->addDays($days),
            ]);
        }

        return back()->with('success', 'Sampel Berhasil Didaftarkan!');
    }
}