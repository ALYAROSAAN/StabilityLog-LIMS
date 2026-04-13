<!DOCTYPE html>
<html>
<head>
    <title>StabilityLog - Pendaftaran Sampel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Pendaftaran Sampel Baru</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="alert alert-info">
                    Saat sampel didaftarkan, sistem otomatis membuat jadwal uji pada H+1, H+7, dan H+30.
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Lihat Produk Tersimpan</a>
                </div>

                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                        >
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
                            value="{{ old('batch_code') }}"
                        >
                        @error('batch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Daftarkan Sampel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>