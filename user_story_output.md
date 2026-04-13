# user_story_output.md

**Prompt:** "Generate kode lengkap (Model, Controller, Form Request, dan Blade View) untuk User Story 1.1: Pendaftaran Sampel. Gunakan Laravel dengan standar teknis skills.md (Dependency Injection, Immutability, Module-based structure). Pastikan ada otomatisasi jadwal H+1, H+7, H+30 dan integrasi QR Code."

**Context File:** StabilityLog PRD, skills.md

**Skills:** skills.md (Standard Laravel & Skincare LIMS Logic)

**Task:** Generate code for User Story 1.1: Registration of Samples

**Input:** `@parameter string $product_name, string $batch_code`

**Output:** `@return Boolean true if success`

**Rules:** Unique batch_code, required fields, auto-generate schedule H+1, H+7, H+30, status "Ready for Testing".

---

## What Changed

- `app/Modules/Product/Models/Product.php` — Definisi entitas produk.
- `app/Modules/Product/Requests/StoreProductRequest.php` — Validasi input form.
- `app/Modules/Product/Services/RegisterProductAction.php` — Logika pendaftaran, QR generation, dan auto-scheduling.
- `app/Modules/Product/Controllers/ProductController.php` — Orchestrator antara Request dan Service.
- `resources/views/modules/product/create.blade.php` — Antarmuka pendaftaran sampel.

**Commit Message:** `feat: implement sample registration with automated scheduling (H+1, H+7, H+30) and QR generation`

---

## Output Source Code

### A. Form Request: `StoreProductRequest.php`

Menangani validasi data sesuai aturan bisnis unik dan wajib isi.

```php
namespace App\Modules\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'batch_code' => 'required|string|unique:products,batch_code',
        ];
    }
}
```

---

### B. Model: `Product.php`

Menggunakan properti untuk menjaga integritas data.

```php
namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'batch_code', 'barcode_qr', 'status_id'];

    // Menghubungkan ke tabel status (Ready for Testing)
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }
}
```

---

### C. Service: `RegisterProductAction.php`

Implementasi logika bisnis otomatisasi jadwal H+1, H+7, H+30 dan pembuatan QR Code.

```php
namespace App\Modules\Product\Services;

use App\Modules\Product\Models\Product;
use App\Modules\LabTest\Models\StabilityTest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class RegisterProductAction
{
    public function execute(array $data): bool
    {
        // 1. Generate QR Code
        $qrPath = 'qrcodes/' . $data['batch_code'] . '.svg';
        QrCode::format('svg')->generate(
            route('products.show', $data['batch_code']),
            public_path($qrPath)
        );

        // 2. Create Product dengan status 'Ready for Testing'
        $product = Product::create([
            'name'       => $data['name'],
            'batch_code' => $data['batch_code'],
            'barcode_qr' => $qrPath,
            'status_id'  => 1, // ID untuk 'Ready for Testing'
        ]);

        // 3. Otomatisasi Jadwal Uji (H+1, H+7, H+30)
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
```

---

### D. Blade View: `create.blade.php`

Menggunakan Bootstrap dan komponen Blade untuk feedback validasi.

```html
<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
        />
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Kode Batch</label>
        <input
            type="text"
            name="batch_code"
            class="form-control @error('batch_code') is-invalid @enderror"
        />
        @error('batch_code')
        <div class="invalid-feedback text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Daftarkan Sampel</button>
</form>
```
