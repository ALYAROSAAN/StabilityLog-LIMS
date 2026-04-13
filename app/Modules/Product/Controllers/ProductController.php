<?php

namespace App\Modules\Product\Controllers;

use App\Models\Product;
use App\Modules\Product\Requests\StoreProductRequest;
use App\Modules\Product\Services\RegisterProductAction;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController
{
    /**
     * Menampilkan daftar semua produk dengan jadwal uji stabilitas
     */
    public function index(): View
    {
        $products = Product::with('stabilityTests')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.product.index', compact('products'));
    }

    /**
     * Menampilkan form pendaftaran sampel baru
     */
    public function create(): View
    {
        return view('modules.product.create');
    }

    /**
     * Menyimpan dan mendaftarkan sampel produk baru
     * - Generate QR Code unik
     * - Buat jadwal uji otomatis (H+1, H+7, H+30)
     * - Set status awal "Ready"
     */
    public function store(StoreProductRequest $request, RegisterProductAction $action): RedirectResponse
    {
        try {
            $action->execute($request->validated());
            
            return redirect()->route('products.index')
                ->with('success', 'Sampel berhasil didaftarkan! Jadwal uji otomatis telah dibuat (H+1, H+7, H+30).');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mendaftarkan sampel. Silahkan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Menampilkan detail produk dengan jadwal uji dan QR Code
     */
    public function show(Product $product): View
    {
        $product->load('stabilityTests');
        return view('modules.product.show', compact('product'));
    }

    /**
     * Menghapus produk dan data testnya
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Cascade delete: stabilityTests akan terhapus otomatis jika foreign key ON DELETE CASCADE
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Sampel berhasil dihapus.');
    }
}