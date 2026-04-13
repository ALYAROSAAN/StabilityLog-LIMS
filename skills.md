# StabilityLog Skills

## Business Context
StabilityLog adalah sistem **Laboratory Information Management System (LIMS)** yang dikembangkan untuk industri skincare. Sistem ini berfungsi untuk:

- Mengelola data uji stabilitas produk skincare.
- Menyediakan otomatisasi jadwal pengujian (H+1, H+7, H+30).
- Menyediakan audit trail untuk setiap perubahan data.
- Memberikan deteksi anomali hasil uji.
- Menghasilkan QR Code unik untuk setiap batch sampel.

## Technical Standards (Laravel)
Prinsip teknis diadaptasi dari best practices Kotlin/Spring Boot agar sesuai dengan ekosistem Laravel:
- **Dependency Injection:** Gunakan Laravel Service Container dan constructor injection untuk dependensi. Hindari penggunaan `facades` secara berlebihan.
- **Immutability:** Gunakan `readonly` properties (PHP 8.2) atau deklarasi `private`/`protected` untuk menjaga integritas data. Hindari mutasi state yang tidak perlu.
- **Configuration:**
  - Gunakan file `.env` untuk konfigurasi eksternal.
  - Gunakan `config/*.php` untuk type-safe configuration.
  - Jangan pernah hardcode secrets; gunakan environment variables atau secret manager.
- **Validation:** Gunakan Laravel Form Request untuk validasi data. Terapkan aturan validasi sesuai domain (misalnya validasi pH).
- **Package Structure:** Organisasi kode berdasarkan domain/feature (`App/Modules/Product`, `App/Modules/LabTest`) bukan hanya berdasarkan layer.
- **Logging:** Gunakan Monolog dengan channel terpisah. Terapkan parameterized logging (`logger()->info('Processing batch', ['batch_id' => $id])`).
- **Testing:**
  - Gunakan PHPUnit sebagai default.
  - Gunakan PestPHP untuk sintaks yang lebih idiomatis.
  - Gunakan Laravel Test Components (`assertDatabaseHas`, `assertJson`) untuk integrasi.
  - Gunakan Testcontainers atau Docker untuk uji integrasi dengan database.

## Mandatory Capabilities
- **Validasi pH:**
  - Nilai pH harus berada di rentang 0.0–14.0.
  - Validasi dilakukan di level Form Request dan Model.
- **Konfigurasi Parameter Pengujian**
  - Saat registrasi, user wajib memilih parameter (pH, Viskositas, atau Organoleptik).
  - User menetapkan ambang batas (min/max) untuk setiap parameter yang dipilih.
- **Otomatisasi Jadwal Uji:**
  - Saat produk diregistrasi, sistem otomatis membuat jadwal uji H+1, H+7, H+30.
- **Deteksi Anomali:**
  - Jika hasil lab di luar batas toleransi, sistem menandai data dengan status anomali.
  - UI menampilkan highlight merah.
- **Audit Trail:**
  - Gunakan Laravel Model Observers untuk mencatat perubahan (`old_value`, `new_value`).
  - Simpan di tabel `audit_logs` dengan metadata user.
- **QR Code Batch:**
  - Generate QR Code unik untuk setiap batch menggunakan library seperti `simple-qrcode`.
  - QR Code berisi informasi batch ID dan link ke detail batch.

## UI Rules (Blade/Bootstrap)
- **Consistency:** Gunakan Blade Components untuk UI reusable (form, table, alert).
- **Validation Feedback:** Tampilkan pesan validasi di bawah input dengan styling Bootstrap `invalid-feedback`.
- **Anomaly Highlight:**
  - Gunakan Bootstrap `table-danger` untuk menandai baris hasil uji yang anomali.
- **Audit Trail Display:**
  - Gunakan modal atau collapsible section untuk menampilkan riwayat perubahan.
- **QR Code:**
  - Tampilkan QR Code di halaman detail batch menggunakan Blade directive.

