<?php

namespace App\Modules\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreProductRequest extends FormRequest
{
    /**
     * Tentukan apakah user ini authorized untuk membuat request ini
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi rules untuk pendaftaran sampel
     * Sesuai Mandatory Capabilities dari skills.md
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'batch_code' => 'required|string|max:100|unique:products,batch_code',
            'parameters' => 'required|array|min:1',
            'parameters.*.enabled' => 'sometimes|boolean',
            'parameters.*.param_name' => 'required|string',
            'parameters.*.min_limit' => 'nullable|numeric',
            'parameters.*.max_limit' => 'nullable|numeric',
        ];
    }

    /**
     * Custom messages untuk validasi
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'batch_code.required' => 'Kode batch wajib diisi.',
            'batch_code.unique' => 'Kode batch sudah terdaftar. Gunakan kode yang berbeda.',
            'batch_code.max' => 'Kode batch maksimal 100 karakter.',
            'parameters.required' => 'Setidaknya satu parameter pengujian harus dipilih.',
            'parameters.array' => 'Daftar parameter tidak valid.',
            'parameters.min' => 'Setidaknya satu parameter pengujian harus dipilih.',
            'parameters.*.param_name.required' => 'Nama parameter diperlukan.',
            'parameters.*.min_limit.required_with' => 'Batas minimum diperlukan ketika parameter dipilih.',
            'parameters.*.max_limit.required_with' => 'Batas maksimum diperlukan ketika parameter dipilih.',
            'parameters.*.min_limit.numeric' => 'Batas minimum harus berupa angka.',
            'parameters.*.max_limit.numeric' => 'Batas maksimum harus berupa angka.',
            'parameters.*.max_limit.gte' => 'Batas maksimum harus lebih besar atau sama dengan batas minimum.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $parameters = $this->input('parameters', []);

            foreach ($parameters as $index => $parameter) {
                if (empty(Arr::get($parameter, 'enabled'))) {
                    continue;
                }

                $paramName = Arr::get($parameter, 'param_name');
                $minLimit = Arr::get($parameter, 'min_limit');
                $maxLimit = Arr::get($parameter, 'max_limit');

                if ($paramName === 'pH') {
                    if ($minLimit < 0.0 || $minLimit > 14.0) {
                        $validator->errors()->add("parameters.{$index}.min_limit", 'Nilai pH minimum harus berada di antara 0.0 dan 14.0.');
                    }
                    if ($maxLimit < 0.0 || $maxLimit > 14.0) {
                        $validator->errors()->add("parameters.{$index}.max_limit", 'Nilai pH maksimum harus berada di antara 0.0 dan 14.0.');
                    }
                }

                if ($minLimit === null) {
                    $validator->errors()->add("parameters.{$index}.min_limit", 'Batas minimum diperlukan ketika parameter dipilih.');
                }

                if ($maxLimit === null) {
                    $validator->errors()->add("parameters.{$index}.max_limit", 'Batas maksimum diperlukan ketika parameter dipilih.');
                }

                if ($minLimit !== null && $maxLimit !== null && $maxLimit < $minLimit) {
                    $validator->errors()->add("parameters.{$index}.max_limit", 'Batas maksimum harus lebih besar atau sama dengan batas minimum.');
                }
            }

            $selectedParameters = collect($parameters)->filter(fn ($parameter) => !empty(Arr::get($parameter, 'enabled')));

            if ($selectedParameters->isEmpty()) {
                $validator->errors()->add('parameters', 'Setidaknya satu parameter pengujian harus dipilih.');
            }
        });
    }
}