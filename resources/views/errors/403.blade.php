<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Terbatas</title>
    <style>
        body { text-align: center; padding: 80px 20px; font-family: system-ui, sans-serif; background: #f9fafb; color: #1f2937; }
        .error-card { max-width: 500px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h1 { font-size: 64px; margin: 0; color: #dc2626; }
        h2 { font-size: 24px; margin-top: 10px; color: #374151; }
        p { color: #6b7280; font-size: 16px; margin-bottom: 30px; }
        .btn-back { display: inline-block; padding: 12px 24px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; transition: background 0.2s; }
        .btn-back:hover { background: #1d4ed8; }
    </style>
</head>
<body>

    <div class="error-card">
        <h1>403</h1>
        <h2>Akses Menu Ditolak</h2>
        <p>Maaf, akun Anda terdaftar sebagai peran yang tidak memiliki otoritas tingkat tinggi untuk mengeksekusi tindakan atau memuat halaman ini.</p>
        
        <a href="{{ route('products.index') }}" class="btn-back">
            Kembali ke Daftar Produk
        </a>
    </div>

</body>
</html>