<?php

namespace App\Modules\Product\Controllers;

use App\Models\Product;
use App\Modules\Product\Requests\StoreProductRequest;
use App\Modules\Product\Services\RegisterProductAction;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController
{
    private array $availableParameters = [
        ['key' => 'ph', 'label' => 'pH', 'hint' => 'Rentang 0.0 - 14.0'],
        ['key' => 'viscosity', 'label' => 'Viskositas', 'hint' => 'Masukkan batas min/max dalam cP'],
        ['key' => 'organoleptic', 'label' => 'Organoleptik', 'hint' => 'Masukkan nilai deskriptif atau ambang batas.'],
    ];

    /**
     * Menampilkan daftar semua produk dengan jadwal uji stabilitas
     */
    public function index(): View
    {
        $products = Product::with(['stabilityTests.testResult', 'testingParameters'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.product.index', compact('products'));
    }

    /**
     * Menampilkan form pendaftaran sampel baru
     */
    public function create(): View
    {
        $availableParameters = $this->availableParameters;

        return view('modules.product.create', compact('availableParameters'));
    }

    /**
     * Menyimpan dan mendaftarkan sampel produk baru
     */
    public function store(StoreProductRequest $request, RegisterProductAction $action): RedirectResponse
    {
        try {
            $action->execute($request->validated());

            return redirect()->route('products.index')
                ->with('success', 'Sampel berhasil didaftarkan! Jadwal uji otomatis telah dibuat (H+1, H+7, H+30).');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mendaftarkan sampel. Silahkan coba lagi. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail produk dengan jadwal uji dan parameter
     */
    public function show(Product $product): View
    {
        $product->load(['stabilityTests.testResult.testingParameter', 'testingParameters', 'auditTrails']);

        return view('modules.product.show', compact('product'));
    }

    /**
     * Menghapus produk dan data testnya
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Sampel berhasil dihapus.');
    }
}