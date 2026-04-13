<!DOCTYPE html>
<html>
<head>
    <title>StabilityLog - Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">Produk Tersimpan</h4>
                <p class="text-muted mb-0">Menampilkan produk yang sudah didaftarkan beserta jadwal uji otomatis.</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Sampel Baru</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Kode Batch</th>
                            <th>Status</th>
                            <th>Jadwal Uji</th>
                            <th>QR Code</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr @class(['table-danger' => $product->stabilityTests->contains(function ($test) { return optional($test->testResult)->is_anomaly; })])>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->batch_code }}</td>
                                <td>{{ $product->status }}</td>
                                <td>
                                    @if($product->stabilityTests->isNotEmpty())
                                        @foreach($product->stabilityTests as $test)
                                            <div>{{ $test->schedule_date }} <small class="text-muted">({{ ucfirst(strtolower($test->status)) }})</small></div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($product->qr_code)
                                        <a href="/{{ $product->qr_code }}" target="_blank">Lihat QR</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus sampel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Belum ada produk terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>