<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StabilityLog - Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">StabilityLog LIMS</a>
            
            <div class="d-flex align-items-center gap-3">
                <span class="text-light">
                    Halo, <strong>{{ auth()->user()->name ?? 'Pengguna' }}</strong> 
                    <span class="badge bg-secondary ms-1">{{ auth()->user()->role->name ?? 'Guest' }}</span>
                </span>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Keluar (Logout)</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 fw-bold">Produk Tersimpan</h4>
                <p class="text-muted mb-0">Menampilkan produk yang sudah didaftarkan beserta jadwal uji otomatis.</p>
            </div>
            
            <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah Sampel Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <x-ui.card class="shadow-sm border-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Nama Produk</th>
                            <th>Kode Batch</th>
                            <th>Status</th>
                            <th>Jadwal Uji</th>
                            <th>QR Code</th>
                            <th class="pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr @class(['table-danger' => $product->stabilityTests->contains(function ($test) { return optional($test->testResult)->is_anomaly; })])>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $product->batch_code }}</span></td>
                                <td>{{ $product->status }}</td>
                                <td>
                                    @if($product->stabilityTests->isNotEmpty())
                                        @foreach($product->stabilityTests as $test)
                                            <div>
                                                {{ $test->schedule_date }} 
                                                <small class="text-muted">({{ ucfirst(strtolower($test->status)) }})</small>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->qr_code)
                                        <a href="/{{ $product->qr_code }}" target="_blank" class="text-decoration-none">Lihat QR</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="pe-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                        
                                        @if(auth()->user() && auth()->user()->hasRole(['Admin', 'Formulator']))
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data stabilitas produk ini?');" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <x-ui.button type="submit" variant="outline-danger" size="sm">Hapus</x-ui.button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Belum ada produk stabilitas yang terdaftar di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>