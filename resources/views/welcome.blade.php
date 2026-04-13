<!DOCTYPE html>
<html>
<head>
    <title>StabilityLog Mockup US 1.1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Pendaftaran Sampel Baru (Formulator R&D)</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="/register" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Batch</label>
                        <input type="text" name="batch_code" class="form-control @error('batch_code') is-invalid @enderror">
                        @error('batch_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftarkan Produk & Generate Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>