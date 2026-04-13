<?php

namespace App\Modules\Product\Controllers;

use App\Models\Product;
use App\Modules\Product\Requests\StoreProductRequest;
use App\Modules\Product\Services\RegisterProductAction;

class ProductController
{
    public function index()
    {
        $products = Product::with('stabilityTests')->orderBy('created_at', 'desc')->get();

        return view('modules.product.index', compact('products'));
    }

    public function create()
    {
        return view('modules.product.create');
    }

    public function store(StoreProductRequest $request, RegisterProductAction $action)
    {
        $action->execute($request->validated());

        return back()->with('success', 'Sampel berhasil didaftarkan!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Sampel berhasil dihapus.');
    }
}