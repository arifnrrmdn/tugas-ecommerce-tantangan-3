<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <style>
            .custom-table {
                width: 100%;
                border: 1px solid #ddd;
                border-collapse: collapse;
            }

            .custom-table th,
            .custom-table td {
                padding: 15px 20px;
                border-bottom: 1px solid #ddd;
            }

            .custom-table th {
                width: 40%;
                font-weight: bold;
                background: transparent;
            }

            .custom-table tr:nth-child(odd) {
                background-color: #f2f2f2;
            }

            .custom-table tr:last-child td,
            .custom-table tr:last-child th {
                border-bottom: none;
        }
</style>
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Detail Produk</h3>

    <table class="table custom-table">
        <tr>
            <th>Kategori Produk</th>
            <td>{{ $data['kategori_produk'] }}</td>
        </tr>
        <tr>
            <th>Nama Produk</th>
            <td>{{ $data['nama_produk'] }}</td>
        </tr>
        <tr>
            <th>Stok</th>
            <td>{{ $data['stok'] }}</td>
        </tr>
        <tr>
            <th>Harga Produk</th>
            <td>Rp{{ number_format($data['harga_produk'], 0, ',', '.') }}</td>
        </tr>
    </table>
    <a href="{{url('/produk/create')}}" class="btn btn-secondary mt-3">← Kembali</a>
</div>

</body>
</html> 