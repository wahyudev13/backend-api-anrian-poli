<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Display Video</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 m-0">Pengaturan Display Video</h1>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('video.display.store') }}" method="POST" class="row gy-2 gx-2 align-items-end">
                    @csrf
                    <div class="col-12 col-md-6">
                        <label for="id_video" class="form-label">Pilih Video</label>
                        <select id="id_video" name="id_video" class="form-select" required>
                            <option value="">-- pilih --</option>
                            @foreach ($videos as $v)
                                <option value="{{ $v->id }}">{{ $v->title ?: $v->original_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="display" class="form-label">Display</label>
                        <select id="display" name="display" class="form-select" required>
                            <option value="loket">Loket</option>
                            <option value="poli-1">Poli 1</option>
                            <option value="poli-2">Poli 2</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="h6 mb-3">Daftar Mapping</h2>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Display</th>
                                <th>Video</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($settings as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td><span class="badge bg-secondary">{{ $s->display }}</span></td>
                                    <td>
                                        <div class="small">Judul: {{ $s->video?->title ?: '-' }}</div>
                                        <div class="small">Nama asli: {{ $s->video?->original_name }}</div>
                                        <div class="text-muted small">{{ $s->video?->url }}</div>
                                    </td>
                                    <td class="d-flex gap-2">
                                        @if ($s->video?->url)
                                            <a class="btn btn-outline-primary btn-sm" href="{{ $s->video->url }}"
                                                target="_blank" rel="noopener noreferrer">View</a>
                                        @endif
                                        <form action="{{ route('video.display.destroy', $s->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus mapping ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
