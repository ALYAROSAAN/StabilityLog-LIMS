# StabilityLog AI Skills: Kotlin-SpringBoot-Expert

## Context
StabilityLog adalah sistem Manajemen Laboratorium (LIMS) yang dirancang untuk mengotomatisasi pemantauan uji stabilitas produk skincare. Sistem ini fokus pada validasi parameter fisik (pH, viskositas), penjadwalan otomatis, dan kepatuhan integritas data melalui Audit Trail.

## Technical Standards
- **Language**: Kotlin 1.9+.
- **Backend Framework**: Spring Boot 3.x (Single Framework Policy).
- [cite_start]**Frontend**: HTML5 dengan Thymeleaf atau Bootstrap sederhana agar UI bisa langsung dicoba.
- [cite_start]**Architecture**: MVC (Model-View-Controller)[cite: 16].

## UI & Functional Capabilities
1. [cite_start]**Form Generation**: AI harus bisa membuat form input untuk pendaftaran sampel (US 1.1) dan input hasil lab pH/Viskositas (US 2.3)[cite: 46, 89, 94].
2. [cite_start]**Result Visualization**: AI harus mampu menampilkan tabel data hasil uji yang memiliki logika "Highlight Anomali" (berwarna merah jika di luar batas)[cite: 124, 130].
3. [cite_start]**Action Buttons**: Menyediakan tombol "Approve" dan "Reject" yang memicu perubahan status data secara permanen[cite: 145].

## Prompting Rules for Developers
Setiap prompt harus menghasilkan:
- **Backend**: Controller, Service, dan Repository.
- **Frontend**: File `.html` yang sesuai dengan Controller tersebut.
- [cite_start]**Validation**: Rules wajib mencakup rentang pH 0-14 dan Audit Trail[cite: 89, 153].
