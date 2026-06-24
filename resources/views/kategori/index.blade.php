<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Data Kategori</h3>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah</a>

        <form action="{{ route('kategori.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari kategori..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama Kategori</th>
                    <th width="120" class="text-center">Jumlah Produk</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($result as $item)
                <tr>
                    <td>{{ $result->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td class="text-center">
                        <span class="badge bg-secondary">{{ $item->produk_count }}</span>
                    </td>
                    <td>
                        <a href="{{ route('kategori.edit', $item->id) }}"
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('kategori.destroy', $item->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                {{ $item->produk_count > 0 ? 'disabled title=Masih ada produk' : '' }}>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Data belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Menampilkan {{ $result->firstItem() ?? 0 }}–{{ $result->lastItem() ?? 0 }}
            dari {{ $result->total() }} kategori
        </small>
        {{ $result->links() }}
    </div>
</div>

</body>
</html>
