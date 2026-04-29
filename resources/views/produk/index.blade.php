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

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">+ Tambah</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th width="100">Foto</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th width="80">Stok</th>
                    <th width="150">Harga</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($result as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- FOTO --}}
                    <td>
                        @if($item->foto_produk && file_exists(public_path('storage/produk/'.$item->foto_produk)))
                            <img src="{{ asset('storage/produk/'.$item->foto_produk) }}"
                                 class="img-thumbnail"
                                 style="width:80px;height:80px;object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center border"
                                 style="width:80px;height:80px;font-size:12px;color:#888;">
                                Produk
                            </div>
                        @endif
                    </td>

                    <td>{{ $item->kategori_produk }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>Rp{{ number_format($item->harga_produk,0,',','.') }}</td>

                    {{-- AKSI --}}
                    <td>
                        <a href="{{ route('produk.edit',$item->id) }}" 
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('produk.destroy',$item->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Data belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>