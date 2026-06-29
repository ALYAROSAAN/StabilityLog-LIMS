<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StabilityLog - Detail Produk</title>
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

    <div class="container pb-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <div>
                    <h4 class="mb-0 fw-bold"><i class="fas fa-info-circle text-primary me-2"></i> Detail Produk</h4>
                    <p class="text-muted mb-0 small mt-1">Informasi lengkap pendaftaran, parameter, dan jadwal uji.</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-secondary shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            
            <div class="card-body p-4">
                <div class="row mb-5">
                    <div class="col-md-7">
                        <h5 class="mb-3 fw-bold border-bottom pb-2">Informasi Umum</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted">Nama Produk</dt>
                            <dd class="col-sm-8 fw-semibold fs-5">{{ $product->name }}</dd>

                            <dt class="col-sm-4 text-muted">Kode Batch</dt>
                            <dd class="col-sm-8"><span class="badge bg-light text-dark border px-2 py-1">{{ $product->batch_code }}</span></dd>

                            <dt class="col-sm-4 text-muted">Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge {{ $product->status == 'Selesai' ? 'bg-success' : 'bg-primary' }}">
                                    {{ $product->status }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-5">
                        <div class="card border-primary shadow-sm h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <h6 class="card-title fw-bold text-primary mb-3"><i class="fas fa-qrcode me-2"></i> QR Code Produk</h6>
                                @if($product->qr_code)
                                    <div class="mb-3 bg-white p-2 border rounded">
                                        <img src="/{{ $product->qr_code }}" alt="QR Code" class="img-fluid" style="max-width: 180px;" />
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="/{{ $product->qr_code }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt me-1"></i> Buka QR</a>
                                        <button class="btn btn-sm btn-outline-success" onclick="window.print()"><i class="fas fa-print me-1"></i> Cetak Label</button>
                                    </div>
                                @else
                                    <div class="text-muted p-4 border border-dashed rounded w-100">
                                        <i class="fas fa-qrcode fa-3x mb-2 text-light"></i><br>
                                        QR Code belum tersedia.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-sliders-h text-primary me-2"></i> Parameter Pengujian</h5>
                    @if($product->testingParameters->isNotEmpty())
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Parameter</th>
                                        <th>Batas Minimum</th>
                                        <th>Batas Maksimum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->testingParameters as $parameter)
                                        <tr>
                                            <td class="fw-semibold">{{ $parameter->param_name }}</td>
                                            <td>{{ $parameter->min_limit ?? '-' }}</td>
                                            <td>{{ $parameter->max_limit ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-secondary">Tidak ada parameter pengujian yang terdaftar untuk produk ini.</div>
                    @endif
                </div>

                <div class="mb-5">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-calendar-check text-primary me-2"></i> Jadwal Uji Stabilitas</h5>
                    @if($product->stabilityTests->isNotEmpty())
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-bordered table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal Jadwal</th>
                                        <th>Status Pengujian</th>
                                        <th>Hasil Analisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->stabilityTests as $test)
                                        <tr @class(['table-danger' => $test->testResult && $test->testResult->is_anomaly])>
                                            <td class="fw-semibold">{{ $test->schedule_date->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge {{ $test->status == 'Selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $test->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($test->testResult)
                                                    <span class="fw-bold">{{ $test->testResult->value }}</span>
                                                    @if($test->testResult->is_anomaly)
                                                        <span class="badge bg-danger ms-2"><i class="fas fa-exclamation-triangle"></i> Anomali</span>
                                                    @else
                                                        <span class="badge bg-success ms-2"><i class="fas fa-check"></i> Normal</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted fst-italic">Belum diuji</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-secondary">Jadwal uji belum dibuat atau dikonfigurasi.</div>
                    @endif
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="fw-bold mb-0"><i class="fas fa-history text-primary me-2"></i> Jejak Audit (Audit Trail)</h5>
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#auditTrailCollapse" aria-expanded="false" aria-controls="auditTrailCollapse">
                            <i class="fas fa-eye me-1"></i> Tampilkan Log Data
                        </button>
                    </div>
                    
                    <div class="collapse" id="auditTrailCollapse">
                        @if($product->auditTrails->isNotEmpty())
                            <ul class="list-group shadow-sm">
                                @foreach($product->auditTrails as $audit)
                                    <li class="list-group-item p-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <strong>{{ ucfirst($audit->event) }} {{ ucfirst(str_replace('_', ' ', $audit->auditable_type)) }} #{{ $audit->auditable_id }}</strong>
                                            <span class="badge bg-secondary"><i class="far fa-clock me-1"></i> {{ $audit->created_at->format('Y-m-d H:i') }}</span>
                                        </div>
                                        <div class="small text-muted mb-2"><i class="fas fa-link me-1"></i> URL: {{ $audit->url }}</div>
                                        <div class="bg-light p-2 rounded border">
                                            <pre class="mb-0 small" style="white-space: pre-wrap; font-family: monospace;">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-secondary">Belum ada jejak riwayat audit untuk produk ini.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, .btn, .collapse, button[data-bs-toggle="collapse"] {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>