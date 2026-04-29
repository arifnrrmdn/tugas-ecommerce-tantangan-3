<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Data Produk</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">+ Tambah</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Kategori</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($result as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    @if($item->foto_produk)
                        <!-- <img src="{{ Storage::url('produk/'.$item->foto_produk) }}" width="80"> -->
                        <img src="{{ Storage::url('produk/'.$item->foto_produk) }}" width="100">
                        
                    @endif
                </td>

                <td>{{ $item->kategori_produk }}</td>
                <td>{{ $item->nama_produk }}</td>
                <td>{{ $item->stok }}</td>
                <td>Rp{{ number_format($item->harga_produk,0,',','.') }}</td>

                <td>
                    <a href="{{ route('produk.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('produk.destroy',$item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>