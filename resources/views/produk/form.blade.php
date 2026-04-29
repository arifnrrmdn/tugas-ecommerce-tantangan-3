<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Form Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>{{ isset($produk) ? 'Edit Produk' : 'Tambah Produk' }}</h3>

    <form action="{{ isset($produk) ? route('produk.update', $produk->id) : route('produk.store') }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($produk))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_produk" class="form-control">
                <option value="">- Pilih -</option>
                <option value="Sepatu" {{ (old('kategori_produk', $produk->kategori_produk ?? '') == 'Sepatu') ? 'selected' : '' }}>Sepatu</option>
                <option value="Baju" {{ (old('kategori_produk', $produk->kategori_produk ?? '') == 'Baju') ? 'selected' : '' }}>Baju</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama_produk" class="form-control"
                   value="{{ old('nama_produk', $produk->nama_produk ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control"
                   value="{{ old('stok', $produk->stok ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga_produk" class="form-control"
                   value="{{ old('harga_produk', $produk->harga_produk ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Foto</label>
            @if(!empty($produk->foto_produk))
                <div class="mb-2">
                    <img src="{{ asset('storage/produk/' . $produk->foto_produk) }}" 
                        alt="Foto Produk" width="100">
                </div>
            @endif

            <input type="file" name="foto_produk" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="/produk" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>