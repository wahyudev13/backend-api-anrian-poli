<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Text Marquee Loket</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
    <style>
        .help-text {
            font-size: .9rem;
            color: #6c757d;
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

        .preview-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .marquee-text {
            font-size: 1.2rem;
            font-weight: 500;
            color: #495057;
            white-space: nowrap;
            overflow: hidden;
            animation: marquee 20s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 m-0">Pengaturan Text Marquee Loket</h1>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
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

                        <form action="{{ route('settings.text_marquee.save') }}" method="POST">
                            @csrf

                            <!-- Current Settings Section -->
                            <div class="mb-4">
                                <div class="section-title">Pengaturan Saat Ini</div>
                                <div class="mb-3">
                                    <label for="value" class="form-label">Text Marquee Loket</label>
                                    <textarea id="value" name="value" rows="3" class="form-control"
                                        placeholder="Masukkan text yang akan ditampilkan sebagai marquee di loket">{{ old('value', $value) }}</textarea>
                                    <div class="help-text mt-1">
                                        Text ini akan ditampilkan sebagai marquee berjalan di layar loket. Maksimal 500
                                        karakter.
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="mb-4">
                                <div class="section-title">Preview Text Marquee</div>
                                <div class="preview-box">
                                    <div class="marquee-text" id="preview-text">
                                        {{ old('value', $value) ?: 'Selamat datang di Rumah Sakit PKU Sekapuk' }}
                                    </div>
                                </div>
                                <div class="help-text mt-2">
                                    Preview di atas menunjukkan bagaimana text akan ditampilkan sebagai marquee
                                    berjalan.
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">

                                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Live preview update
        document.getElementById('value').addEventListener('input', function() {
            const previewText = document.getElementById('preview-text');
            const inputValue = this.value;

            if (inputValue.trim() === '') {
                previewText.textContent = 'Selamat datang di Rumah Sakit PKU Sekapuk';
            } else {
                previewText.textContent = inputValue;
            }
        });
    </script>
</body>

</html>
