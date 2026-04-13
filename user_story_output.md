# user_story_output.md

**Prompt:** "Generate kode lengkap (Model, Controller, Form Request, dan Blade View) untuk User Story 1.1: Pendaftaran Sampel. Gunakan Laravel dengan standar teknis skills.md (Dependency Injection, Immutability, Module-based structure). Pastikan ada otomatisasi jadwal H+1, H+7, H+30 dan integrasi QR Code."

**Context File:** StabilityLog PRD, skills.md

**Skills:** skills.md (Standard Laravel & Skincare LIMS Logic)

**Task:** Generate code for User Story 1.1: Registration of Samples

**Input:** `@parameter string $product_name, string $batch_code`

**Output:** `@return Boolean true if success`

**Rules:** Unique batch_code, required fields, auto-generate schedule H+1, H+7, H+30, status "Ready".

---

## What Changed

- `app/Models/Product.php` — Eloquent model untuk produk dan relasi ke stability test, testing parameter, audit trail.
- `app/Models/TestingParameter.php` — Model penyimpanan parameter uji dengan validasi pH di model.
- `app/Modules/Product/Controllers/ProductController.php` — Orchestrator antara request, service, dan view.
- `app/Modules/Product/Requests/StoreProductRequest.php` — Validasi input form termasuk checkbox parameter, min/max, dan validasi pH.
- `app/Modules/Product/Services/RegisterProductAction.php` — Logika pendaftaran, penyimpanan parameter, QR generation, dan auto-scheduling.
- `resources/views/modules/product/create.blade.php` — Form register dengan parameter uji, checkbox, dan UI Bootstrap.

**Commit Message:** `feat: implement sample registration with parameter-driven testing, QR generation, and automated schedule creation`

---

## Output Source Code

### A. Form Request: `StoreProductRequest.php`

Validasi input pendaftaran sampel dan parameter uji.

```php
class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'batch_code' => 'required|string|max:100|unique:products,batch_code',
            'parameters' => 'required|array|min:1',
            'parameters.*.enabled' => 'sometimes|boolean',
            'parameters.*.param_name' => 'required|string',
            'parameters.*.min_limit' => 'nullable|numeric',
            'parameters.*.max_limit' => 'nullable|numeric',
        ];
    }
}
```

---

### B. Model: `app/Models/Product.php`

Definisi entitas produk dengan relasi ke parameter uji.

```php
class Product extends Model
{
    protected $fillable = ['name', 'batch_code', 'qr_code', 'status'];

    public function testingParameters(): HasMany
    {
        return $this->hasMany(TestingParameter::class);
    }
}
```

---

### C. Service: `RegisterProductAction.php`

Logika pendaftaran sampel dengan QR generation dan jadwal otomatis.

```php
class RegisterProductAction
{
    public function execute(string $product_name, string $batch_code): bool
    {
        $qrPath = 'qrcodes/' . $batch_code . '.svg';
        QrCode::format('svg')->generate(route('products.show', $batch_code), public_path($qrPath));

        $product = Product::create([
            'name' => $product_name,
            'batch_code' => $batch_code,
            'qr_code' => $qrPath,
            'status' => 'Ready',
        ]);

        foreach ($data['parameters'] as $param) {
            if (empty($param['enabled'])) {
                continue;
            }

            TestingParameter::create([
                'product_id' => $product->id,
                'param_name' => $param['param_name'],
                'min_limit' => $param['min_limit'],
                'max_limit' => $param['max_limit'],
            ]);
        }

        foreach ([1, 7, 30] as $days) {
            StabilityTest::create([
                'product_id' => $product->id,
                'schedule_date' => Carbon::now()->addDays($days),
                'status' => 'Scheduled',
            ]);
        }

        return true;
    }
}
```

---

### D. Blade View: `create.blade.php`

Form register dengan variabel penting saja.

```html
<input name="name" value="{{ old('name') }}" />
<input name="batch_code" value="{{ old('batch_code') }}" />

@foreach($availableParameters as $item)
<input
    type="checkbox"
    name="parameters[{{ $item['key'] }}][enabled]"
    value="1"
/>
<input
    type="hidden"
    name="parameters[{{ $item['key'] }}][param_name]"
    value="{{ $item['label'] }}"
/>
<input type="number" name="parameters[{{ $item['key'] }}][min_limit]" />
<input type="number" name="parameters[{{ $item['key'] }}][max_limit]" />
@endforeach
```
