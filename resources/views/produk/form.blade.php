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

    <form action="{{ isset($produk) ? route('produk.update', $produk->id) : route('produk.store') }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($produk))
            @method('PUT')
        @endif

        {{-- KATEGORI --}}
        <div class="mb-3">
            <label>Kategori</label>
            <select name="id_kategori_produk" class="form-control">
                <option value="">- Pilih -</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ (old('id_kategori_produk', $produk->id_kategori_produk ?? '') == $kat->id) ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- NAMA --}}
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama_produk" class="form-control"
                   value="{{ old('nama_produk', $produk->nama_produk ?? '') }}">
        </div>

        {{-- STOK --}}
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control"
                   value="{{ old('stok', $produk->stok ?? '') }}">
        </div>

        {{-- HARGA --}}
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga_produk" class="form-control"
                   value="{{ old('harga_produk', $produk->harga_produk ?? '') }}">
        </div>

        {{-- FOTO --}}
        <div class="mb-3">
            <label>Foto Produk</label>

            {{-- PREVIEW FOTO LAMA --}}
            @if(!empty($produk->foto_produk) && file_exists(public_path('storage/produk/'.$produk->foto_produk)))
                <div class="mb-2">
                    <small class="text-muted">Foto saat ini:</small><br>
                    <img src="{{ asset('storage/produk/' . $produk->foto_produk) }}" width="100">
                </div>
            @endif

            {{-- PREVIEW FOTO BARU --}}
            <div class="mb-2">
                <img id="preview" width="100" style="display:none;">
            </div>

            <input type="file" name="foto_produk" class="form-control" onchange="previewImage(event)">

            <small class="text-muted">
                Format: jpg, jpeg, png, webp | Maks: 2MB
            </small>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="/produk" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- SCRIPT PREVIEW --}}
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>