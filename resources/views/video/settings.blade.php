<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Video Display</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 m-0">Pengaturan Video Display</h1>
            <a href="/" class="btn btn-outline-secondary btn-sm">Kembali</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('video.settings.save') }}" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul Tampilan</label>
                <input type="text" id="title" name="title" class="form-control"
                    value="{{ old('title', $title) }}" maxlength="100">
            </div>

            <div class="mb-3">
                <label for="marquee_text" class="form-label">Teks Marquee</label>
                <textarea id="marquee_text" name="marquee_text" class="form-control" rows="3" maxlength="500">{{ old('marquee_text', $marquee_text) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
