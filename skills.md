# StabilityLog AI Skills: Kotlin-SpringBoot-Expert

## Context
StabilityLog adalah sistem Manajemen Laboratorium (LIMS) yang dirancang untuk mengotomatisasi pemantauan uji stabilitas produk skincare. Sistem ini fokus pada validasi parameter fisik (pH, viskositas), penjadwalan otomatis, dan kepatuhan integritas data melalui Audit Trail.

## Technical Standards
- **Language**: Kotlin 1.9+
- **Framework**: Spring Boot 3.x
- **Architecture**: Model-View-Controller (MVC) dengan Service Layer.
- **Database**: PostgreSQL / H2 (untuk pengembangan).
- **Security**: Role-Based Access Control (RBAC) & Digital Signature via PIN.

## Capabilities & Constraints
### 1. Data Validation Skills
- **pH Control**: AI harus selalu menerapkan validasi angka di rentang 0.0 hingga 14.0.
- **Anomaly Detection**: AI wajib menyertakan logika pengecekan jika nilai input menyimpang dari standar produk yang ditentukan.

### 2. Integrity & Audit Skills
- **Audit Logging**: Setiap fungsi `update` wajib menyertakan pemanggilan ke class `AuditTrail` untuk mencatat `old_value`, `new_value`, dan `timestamp`.
- **Immutability**: Data hasil uji yang sudah disetujui (Approved) tidak boleh dapat diubah kembali.

### 3. Scheduling & QR Skills
- **Auto-Scheduling**: Mampu menghasilkan jadwal otomatis untuk H+1, H+7, H+14, dan H+28 setelah produk didaftarkan.
- **QR Generator**: Mengintegrasikan library untuk generate QR Code unik berdasarkan kombinasi `Product_ID` dan `Batch_Code`.

## Prompting Rules for Developers
Setiap permintaan pembuatan kode (Prompt) harus mengikuti format berikut:
- **Input**: Menggunakan anotasi `@parameter` untuk variabel masukan.
- **Output**: Menggunakan anotasi `@return` dengan tipe data yang jelas.
- **Rules**: Mencantumkan logika validasi bisnis (Business Rules).
- **What Changed**: Deskripsi singkat mengenai perubahan pada struktur file.
