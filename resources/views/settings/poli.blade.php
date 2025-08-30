<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Poli</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
    <style>
        .help-text {
            font-size: .9rem;
            color: #6c757d;
        }

        .polyclinic-item {
            cursor: pointer;
            padding: 8px 12px;
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.2s;
        }

        .polyclinic-item:hover {
            background-color: #f8f9fa;
        }

        .polyclinic-item:last-child {
            border-bottom: none;
        }

        .selected-polyclinic {
            background-color: #e3f2fd;
            border-left: 3px solid #2196f3;
        }

        .existing-polyclinic {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }

        .existing-polyclinic:hover {
            background-color: #f8f9fa;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            font-size: 0.75rem;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 m-0">Pengaturan Poli</h1>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-warning" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif

                        <form action="{{ route('settings.poli.save') }}" method="POST">
                            @csrf

                            <!-- Current Settings Section -->
                            <div class="mb-4">
                                <div class="section-title">Pengaturan Saat Ini</div>
                                <div class="mb-3">
                                    <label for="value" class="form-label">Kode Poli Digunakan</label>
                                    <input type="text" id="value" name="value"
                                        value="{{ old('value', $value) }}" class="form-control"
                                        placeholder="contoh: U0005,INT">
                                    <div class="help-text mt-1">Pisahkan dengan koma. Contoh: <code>U0005,INT</code>
                                    </div>
                                </div>
                            </div>

                            <!-- Polyclinic Selection Section -->
                            <div class="mb-4">
                                <div class="section-title">Tambah Poliklinik Baru</div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" id="searchPolyclinic" class="form-control"
                                                placeholder="Cari poliklinik..." onkeyup="filterPolyclinics()">
                                            <button class="btn btn-outline-secondary" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#polyclinicList">
                                                <i class="bi bi-chevron-down"></i> Pilih
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="addSelectedPolyclinics()">
                                            Tambahkan ke Kode
                                        </button>
                                    </div>
                                </div>

                                <!-- Polyclinic List -->
                                <div class="collapse mt-2" id="polyclinicList">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">Poliklinik Tersedia
                                                        ({{ $polyclinics->count() }})</small>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <small class="text-muted">Klik untuk pilih</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                                            @if ($polyclinics->count() > 0)
                                                @foreach ($polyclinics as $poli)
                                                    <div class="polyclinic-item" data-kode="{{ $poli->kd_poli }}"
                                                        data-nama="{{ $poli->nm_poli }}"
                                                        onclick="togglePolyclinicSelection(this)">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>{{ $poli->kd_poli }}</strong> -
                                                                {{ $poli->nm_poli }}
                                                            </div>
                                                            <span class="badge bg-secondary status-badge">Klik untuk
                                                                pilih</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="p-3 text-center text-muted">
                                                    <div class="mb-2">
                                                        <i class="bi bi-check-circle text-success"></i>
                                                    </div>
                                                    Semua poliklinik sudah ditambahkan ke pengaturan
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="help-text mt-2">
                                    Hanya menampilkan poliklinik yang belum ada di pengaturan saat ini.
                                    Pilih poliklinik dari daftar di atas, lalu klik "Tambahkan ke Kode".
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        let selectedPolyclinics = [];

        function filterPolyclinics() {
            const searchTerm = document.getElementById('searchPolyclinic').value.toLowerCase();
            const polyclinicItems = document.querySelectorAll('.polyclinic-item');

            polyclinicItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function togglePolyclinicSelection(element) {
            const kode = element.dataset.kode;
            const nama = element.dataset.nama;

            if (element.classList.contains('selected-polyclinic')) {
                // Remove selection
                element.classList.remove('selected-polyclinic');
                selectedPolyclinics = selectedPolyclinics.filter(p => p.kode !== kode);
                element.querySelector('.badge').textContent = 'Klik untuk pilih';
                element.querySelector('.badge').className = 'badge bg-secondary status-badge';
            } else {
                // Add selection
                element.classList.add('selected-polyclinic');
                selectedPolyclinics.push({
                    kode,
                    nama
                });
                element.querySelector('.badge').textContent = 'Terpilih';
                element.querySelector('.badge').className = 'badge bg-success status-badge';
            }
        }

        function addSelectedPolyclinics() {
            if (selectedPolyclinics.length === 0) {
                alert('Pilih poliklinik terlebih dahulu!');
                return;
            }

            const valueInput = document.getElementById('value');
            const currentValue = valueInput.value.trim();
            const selectedCodes = selectedPolyclinics.map(p => p.kode);

            let newValue = '';
            if (currentValue) {
                // Check if codes already exist
                const existingCodes = currentValue.split(',').map(code => code.trim());
                const newCodes = selectedCodes.filter(code => !existingCodes.includes(code));

                if (newCodes.length > 0) {
                    newValue = currentValue + ',' + newCodes.join(',');
                } else {
                    newValue = currentValue;
                }
            } else {
                newValue = selectedCodes.join(',');
            }

            valueInput.value = newValue;

            // Clear selections
            selectedPolyclinics.forEach(poli => {
                const element = document.querySelector(`[data-kode="${poli.kode}"]`);
                if (element) {
                    element.classList.remove('selected-polyclinic');
                    element.querySelector('.badge').textContent = 'Klik untuk pilih';
                    element.querySelector('.badge').className = 'badge bg-secondary status-badge';
                }
            });
            selectedPolyclinics = [];

            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show mt-2';
            alertDiv.innerHTML = `
                <strong>Berhasil!</strong> Kode poliklinik telah ditambahkan ke pengaturan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('form'));

            // Auto-dismiss after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }
    </script>
</body>

</html>
