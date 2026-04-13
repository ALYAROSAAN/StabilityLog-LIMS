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
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .container { max-width: 960px; }
        .card {
            border: none;
            border-radius: 0.5rem;
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }
        .card-header h5 { font-weight: 700; margin: 0; }
        .form-label { font-weight: 500; color: #333; margin-bottom: 8px; }
        .form-control { border-radius: 0.5rem; }
        .form-control.is-invalid { border-color: #dc3545; }
        .invalid-feedback { font-size: 13px; margin-top: 5px; display: block; }
        .alert { border-radius: 0.5rem; border: none; padding: 15px; margin-bottom: 20px; }
        .btn-primary { border-radius: 0.5rem; padding: 12px; font-weight: 600; }
        .btn-outline-secondary { border-radius: 0.5rem; }
        .info-box { display: flex; align-items: flex-start; padding: 15px; background-color: #ffffff; border-radius: 0.5rem; border: 1px solid #e9ecef; margin-bottom: 20px; }
        .info-box i { color: #0d6efd; margin-right: 12px; margin-top: 2px; }
        .title-section { text-align: left; color: #212529; margin-bottom: 30px; }
        .title-section h1 { font-weight: 700; margin-bottom: 0.5rem; }
        .title-section p { font-size: 14px; color: #6c757d; }
        .parameter-card { border-radius: 0.75rem; }
        .parameter-card .card-body { padding: 1.25rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="title-section">
            <h1>StabilityLog</h1>
            <p>Sistem Manajemen Uji Stabilitas Skincare</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="text-center"><i class="fas fa-plus-circle me-2"></i> Pendaftaran Sampel Baru</h5>
            </div>
            
            <div class="card-body" style="padding: 30px;">
                @if(session('success'))
                    <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}</div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="name"><i class="fas fa-cube me-2" style="color: #667eea;"></i> Nama Produk</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Serum Vitamin C" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback"><i class="fas fa-times-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="batch_code"><i class="fas fa-barcode me-2" style="color: #667eea;"></i> Kode Batch</label>
                        <input type="text" id="batch_code" name="batch_code" class="form-control @error('batch_code') is-invalid @enderror" placeholder="Contoh: BATCH-2024-001" value="{{ old('batch_code') }}" required>
                        @error('batch_code')
                            <div class="invalid-feedback"><i class="fas fa-times-circle"></i> {{ $message }}</div>
                        @enderror
                        <small class="d-block mt-2" style="color: #666;"><i class="fas fa-lightbulb" style="color: #ffc107;"></i> Kode batch harus unik.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-sliders-h me-2" style="color: #667eea;"></i> Parameter Pengujian</label>
                        <p class="text-muted" style="font-size: 13px;">Pilih minimal satu parameter dan isikan ambang batas min/max.</p>

                        @foreach($availableParameters as $item)
                            <div class="card parameter-card mb-3 border-secondary">
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="param_{{ $item['key'] }}" data-param-key="{{ $item['key'] }}" name="parameters[{{ $item['key'] }}][enabled]" value="1" {{ old('parameters.' . $item['key'] . '.enabled') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="param_{{ $item['key'] }}">{{ $item['label'] }}</label>
                                    </div>
                                    <p class="text-secondary small mb-3">{{ $item['hint'] }}</p>

                                    <input type="hidden" name="parameters[{{ $item['key'] }}][param_name]" value="{{ $item['label'] }}">

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label" for="min_{{ $item['key'] }}">Batas Min</label>
                                            <input type="number" step="0.01" id="min_{{ $item['key'] }}" name="parameters[{{ $item['key'] }}][min_limit]" class="form-control @error('parameters.' . $item['key'] . '.min_limit') is-invalid @enderror" value="{{ old('parameters.' . $item['key'] . '.min_limit') }}" {{ old('parameters.' . $item['key'] . '.enabled') ? '' : 'disabled' }}>
                                            @error('parameters.' . $item['key'] . '.min_limit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="max_{{ $item['key'] }}">Batas Max</label>
                                            <input type="number" step="0.01" id="max_{{ $item['key'] }}" name="parameters[{{ $item['key'] }}][max_limit]" class="form-control @error('parameters.' . $item['key'] . '.max_limit') is-invalid @enderror" value="{{ old('parameters.' . $item['key'] . '.max_limit') }}" {{ old('parameters.' . $item['key'] . '.enabled') ? '' : 'disabled' }}>
                                            @error('parameters.' . $item['key'] . '.max_limit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @error('parameters')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-check me-2"></i> Daftarkan Sampel</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="fas fa-list me-2"></i> Lihat Daftar Produk</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const parameterCheckboxes = document.querySelectorAll('.form-check-input');

            const toggleParameterInputs = (checkbox) => {
                const key = checkbox.dataset.paramKey;
                const minInput = document.getElementById(`min_${key}`);
                const maxInput = document.getElementById(`max_${key}`);

                if (!minInput || !maxInput) {
                    return;
                }

                const enabled = checkbox.checked;
                minInput.disabled = !enabled;
                maxInput.disabled = !enabled;

                if (!enabled) {
                    minInput.value = minInput.value ? minInput.value : '';
                    maxInput.value = maxInput.value ? maxInput.value : '';
                }
            };

            parameterCheckboxes.forEach((checkbox) => {
                toggleParameterInputs(checkbox);
                checkbox.addEventListener('change', function () {
                    toggleParameterInputs(this);
                });
            });
        });
    </script>
</body>
</html>