<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Form Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>{{ isset($pelanggan) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</h3>

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

    <form action="{{ isset($pelanggan) ? route('pelanggan.update', $pelanggan->id) : route('pelanggan.store') }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($pelanggan))
            @method('PUT')
        @endif

        {{-- NAMA --}}
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required
                   value="{{ old('nama_lengkap', $pelanggan->nama_lengkap ?? '') }}">
        </div>

        {{-- JENIS KELAMIN --}}
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">- Pilih -</option>
                <option value="L" {{ old('jenis_kelamin', $pelanggan->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $pelanggan->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        {{-- NOMOR HP --}}
        <div class="mb-3">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" required
                   value="{{ old('nomor_hp', $pelanggan->nomor_hp ?? '') }}">
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required
                   value="{{ old('email', $pelanggan->email ?? '') }}">
        </div>

        {{-- FOTO --}}
        <div class="mb-3">
            <label>Foto</label>

            {{-- FOTO LAMA --}}
            @if(!empty($pelanggan->foto))
                <div class="mb-2">
                    <small class="text-muted">Foto saat ini:</small><br>
                    <img src="{{ asset('storage/pelanggan/' . $pelanggan->foto) }}" width="100">
                </div>
            @endif

            {{-- PREVIEW BARU --}}
            <div class="mb-2">
                <img id="preview" width="100" style="display:none;">
            </div>

            <input type="file" name="foto" class="form-control" onchange="previewImage(event)">

            <small class="text-muted">
                Format: jpg, jpeg, png, webp | Maks: 2MB
            </small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/pelanggan" class="btn btn-secondary">Kembali</a>
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