<?php

namespace App\Modules\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Tentukan apakah user ini authorized untuk membuat request ini
     */
    public function authorize(): bool
    {
        // TODO: Implementasi authorization berbasis role (Formulator)
        return true;
    }

    /**
     * Validasi rules untuk pendaftaran sampel
     * Sesuai Mandatory Capabilities dari skills.md
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'batch_code' => 'required|string|max:100|unique:products,batch_code',
        ];
    }

    /**
     * Custom messages untuk validasi
     */
    public function messages(): array
    {
        return [
            'name.required'           => 'Nama produk wajib diisi.',
            'name.string'             => 'Nama produk harus berupa teks.',
            'name.max'                => 'Nama produk maksimal 255 karakter.',
            'batch_code.required'     => 'Kode batch wajib diisi.',
            'batch_code.unique'       => 'Kode batch sudah terdaftar. Gunakan kode yang berbeda.',
            'batch_code.max'          => 'Kode batch maksimal 100 karakter.',
        ];
    }
}