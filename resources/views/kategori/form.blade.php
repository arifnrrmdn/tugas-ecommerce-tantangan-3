<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>{{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store') }}"
          method="POST">
        @csrf
        @if(isset($kategori))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   class="form-control @error('nama_kategori') is-invalid @enderror"
                   value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                   placeholder="Contoh: Sepatu, Baju, Aksesoris..."
                   autofocus>
            @error('nama_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
