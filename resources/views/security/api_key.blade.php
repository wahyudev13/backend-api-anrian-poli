<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Key</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 m-0">API Key</h1>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-2">Gunakan API key ini di header <code>X-API-KEY</code> untuk akses API.</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ session('api_key') ?? ($apiKey ?? '') }}"
                        readonly>
                    <button class="btn btn-outline-secondary" type="button" onclick="copyKey()">Copy</button>
                </div>
                <form action="{{ route('security.api_key.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Generate API key baru? Kunci lama akan diganti.')">Generate
                        Baru</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function copyKey() {
            const input = document.querySelector('input.form-control');
            input.select();
            document.execCommand('copy');
            alert('API key disalin');
        }
    </script>
    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
