<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StabilityLog - Pendaftaran Sampel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .container { max-width: 500px; }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-radius: 15px 15px 0 0 !important;
            padding: 25px;
        }
        .card-header h5 { font-weight: 600; margin: 0; }
        .form-label { font-weight: 500; color: #333; margin-bottom: 8px; }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-control.is-invalid { border-color: #dc3545; }
        .invalid-feedback { font-size: 13px; margin-top: 5px; display: block; }
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-info { background-color: #e7f3ff; color: #004085; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-outline-secondary {
            border-radius: 8px;
            color: #667eea;
            border-color: #667eea;
        }
        .btn-outline-secondary:hover {
            background-color: #667eea;
            color: white;
        }
        .info-box {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            margin-bottom: 20px;
        }
        .info-box i {
            color: #667eea;
            margin-right: 12px;
            margin-top: 2px;
        }
        .title-section {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .title-section h1 { font-weight: 700; margin-bottom: 10px; }
        .title-section p { font-size: 14px; opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title-section">
            <h1><i class="fas fa-flask"></i> StabilityLog</h1>
            <p>Sistem Manajemen Uji Stabilitas Skincare</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="text-center">
                    <i class="fas fa-plus-circle me-2"></i> Pendaftaran Sampel Baru
                </h5>
            </div>
            
            <div class="card-body" style="padding: 30px;">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="info-box">
                    <i class="fas fa-info-circle fa-lg"></i>
                    <div>
                        <strong>Otomatisasi Jadwal Uji</strong>
                        <p style="margin: 5px 0 0 0; font-size: 13px;">
                            Saat pendaftaran, sistem akan otomatis membuat jadwal pengujian pada H+1, H+7, dan H+30 hari.
                        </p>
                    </div>
                </div>

                <form action="{{ route('products.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="name">
                            <i class="fas fa-cube me-2" style="color: #667eea;"></i> Nama Produk
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Contoh: Serum Vitamin C"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="batch_code">
                            <i class="fas fa-barcode me-2" style="color: #667eea;"></i> Kode Batch
                        </label>
                        <input
                            type="text"
                            id="batch_code"
                            name="batch_code"
                            class="form-control @error('batch_code') is-invalid @enderror"
                            placeholder="Contoh: BATCH-2024-001"
                            value="{{ old('batch_code') }}"
                            required
                        >
                        @error('batch_code')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="d-block mt-2" style="color: #666;">
                            <i class="fas fa-lightbulb" style="color: #ffc107;"></i> Kode batch harus unik.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check me-2"></i> Daftarkan Sampel
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i> Lihat Daftar Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('form');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>