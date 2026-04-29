<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Data Pelanggan</h3>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary mb-3">+ Tambah</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>No HP</th>
                <th>Email</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- FOTO --}}
                <td>
                    @if(!empty($item->foto))
                        <img src="{{ asset('storage/pelanggan/'.$item->foto) }}" width="80">
                    @else
                        <div style="width:80px;height:80px;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:12px;">
                            Pelanggan
                        </div>
                    @endif
                </td>

                {{-- DATA --}}
                <td>{{ $item->nama_lengkap }}</td>
                <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $item->nomor_hp }}</td>
                <td>{{ $item->email }}</td>

                {{-- AKSI --}}
                <td>
                    <a href="{{ route('pelanggan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>