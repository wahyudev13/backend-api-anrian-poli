<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Utama</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 m-0">Menu Utama</h1>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="list-group shadow-sm">
                    <a href="{{ route('videos.upload.form') }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>Upload Video</span>
                    </a>
                    <a href="{{ route('video.display.index') }}" class="list-group-item list-group-item-action">
                        Mapping Display Video
                    </a>
                    <a href="{{ route('settings.poli.show') }}" class="list-group-item list-group-item-action">
                        Pengaturan POLI Digunakan
                    </a>
                    <a href="{{ url('/api/videos') }}" class="list-group-item list-group-item-action">Daftar Video
                        (JSON)</a>
                    <a href="{{ route('settings.text_marquee.show') }}"
                        class="list-group-item list-group-item-action">Text
                        Marquee Loket</a>
                    <a href="{{ route('security.api_key.show') }}" class="list-group-item list-group-item-action">API
                        Key</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
