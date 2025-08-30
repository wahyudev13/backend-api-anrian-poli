<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Video</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 m-0">Pengaturan Display Video</h1>
            <a href="/" class="btn btn-outline-secondary btn-sm">Kembali</a>
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

                        <form action="{{ route('videos.upload.submit') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}"
                                    class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label">File Video (MP4 saja)</label>
                                <input type="file" id="video" name="video" accept="video/mp4"
                                    class="form-control" required />
                                <div class="invalid-feedback">Silakan pilih file video MP4.</div>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>

                        @if (isset($videos))
                            <hr class="my-4" />
                            <h2 class="h5 mb-3">Daftar Video Terunggah</h2>
                            @if ($videos->count() === 0)
                                <div class="alert alert-info mb-0">Belum ada video yang diunggah.</div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 48px;">#</th>
                                                <th>Judul</th>
                                                <th>Nama Asli</th>
                                                <th>Ukuran</th>
                                                <th>Tanggal</th>
                                                <th>Preview</th>
                                                <th>Link</th>
                                                <th style="width: 90px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($videos as $index => $video)
                                                <tr>
                                                    <td>{{ $videos->firstItem() + $index }}</td>
                                                    <td>{{ $video->title ?? '-' }}</td>
                                                    <td>{{ $video->original_name }}</td>
                                                    <td>{{ number_format(($video->size_bytes ?? 0) / 1048576, 2) }} MB
                                                    </td>
                                                    <td>{{ optional($video->created_at)->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        <video src="{{ $video->url }}" controls preload="metadata"
                                                            style="max-width: 200px; height: auto;"></video>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-outline-primary btn-sm"
                                                            href="{{ $video->url }}" target="_blank"
                                                            rel="noopener">Buka</a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('videos.destroy', $video) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus video ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-sm">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    {{ $videos->withQueryString()->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
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
