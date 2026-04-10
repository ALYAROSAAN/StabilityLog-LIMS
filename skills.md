# StabilityLog AI Skills: Kotlin-SpringBoot-Expert

## 1. Context
StabilityLog adalah sistem Manajemen Laboratorium (LIMS) yang dirancang untuk mengotomatisasi pemantauan uji stabilitas produk skincare. Sistem ini fokus pada validasi parameter fisik (pH, viskositas), penjadwalan otomatis, dan kepatuhan integritas data melalui Audit Trail untuk menjamin kualitas produk sesuai standar BPOM

## 2. Technical Stack Standards
- **Architecture**: Gunakan pola MVC (Model-View-Controller) dengan Service Layer untuk memisahkan logika bisnis.
- **ependency Injection**: Manfaatkan Constructor Injection pada Controller untuk memanggil Service secara otomatis.
- **Immutability & Data Integrity**: Gunakan Eloquent Model dengan properti $fillable yang ketat dan manfaatkan Database Transactions (DB::transaction) untuk operasi kompleks.
- **Web Layer**: Gunakan Laravel Request Validation untuk memvalidasi input DTO (Data Transfer Object).
- **Error Handling**: Implementasikan Global Exception Handler atau gunakan try-catch di tingkat Service untuk respon error yang konsisten.
- **Logging**: Gunakan facade Log Laravel untuk mencatat aktivitas sistem dan error aplikasi.
  
## 3. Mandatory AI Capabilities (Skills)
### A. UI Generation Skill
- AI harus mampu menghasilkan file `.html` (Thymeleaf) yang memiliki form input lengkap dengan label dan tombol aksi.
- Setiap form wajib memiliki validasi sisi klien (misal: `required`, `min`, `max`).
- UI harus memiliki form input untuk pendaftaran sampel (US 1.1) yang terhubung langsung ke database.

### B. Business Logic & Validation Skill
- **Validation**: Nilai pH wajib divalidasi pada rentang 0.0 - 14.0
- **Auto-Scheduling**: Saat registrasi produk, AI wajib men-generate jadwal uji secara otomatis berdasarkan interval (H+1, H+7, H+30)
- **QR Generation**: Mensimulasikan pembuatan QR Code unik untuk setiap batch sampel

### C. Integrity & Security Skill
- **Audit Trail**: Setiap operasi simpan/update harus mencatat siapa yang melakukan aksi, kapan, dan nilai apa yang berubah
- **RBAC**: Implementasi logika pengecekan Role (Formulator vs Teknisi) pada setiap akses menu.

## 4. Output Formatting Rules
Setiap kode yang dihasilkan AI harus mengikuti format laporan:
1. **Input**: Gunakan anotasi `@parameter` untuk parameter fungsi.
2. **Output**: Gunakan anotasi `@return` untuk tipe data kembalian.
3. **Rules**: Tuliskan komentar `//validation` di dalam blok kode.
4. **What Changed**: Penjelasan file apa saja yang dibuat atau diubah.
5. **Commit Message**: Pesan commit sesuai standar Git.
