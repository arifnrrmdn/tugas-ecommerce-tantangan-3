<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ariev', function () {
    return view('view-belajar');
});

/*
|--------------------------------------------------------------------------
| ROUTE PRODUK (CRUD LENGKAP)
|--------------------------------------------------------------------------
*/

Route::resource('produk', ProdukController::class);

Route::resource('pelanggan', PelangganController::class);

Route::resource('kategori', KategoriController::class);

/*
|--------------------------------------------------------------------------
| ROUTE BELAJAR (BIARKAN)
|--------------------------------------------------------------------------
*/
Route::get('/belajar-kirim-data', [ProdukController::class, 'index']);

Route::get('/belajar-kirim-data-2', function () {
    $name = "Dudung Surudung";
    $jk = "Laki-laki";
    $role = "ERP Technical Developer";
    return view('view-data', compact('name', 'jk', 'role'));
});

Route::get('/route-biodata', function () {
    $data_mahasiswa = [
        'nim' => 10522014,
        'nama_lengkap' => 'Arif N Ramadhan',
        'kelas' => 'IS-1',
        'jurusan' => 'Sistem Informasi',
        'alamat' => 'Jl. Jenderal Sudirman, Sukabumi'
    ];

    return view('view-biodata', $data_mahasiswa);
});

Route::get('/route-dosen', function () {
    return view('view-dosen', [
        'nip' => '4127.70.26.124',
        'nidn' => '0423019401',
        'nama_lengkap' => 'Ferry Stephanus Suwita, S.Kom., M.T.',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '14-Desember-1995'
    ]);
});

Route::get('/route-produk', function () {
    return view('view-produk', [
        'nama_produk' => 'Vans Classic Slip On',
        'warna' => 'Hitam',
        'ukuran' => '40',
        'jumlah' => 90
    ]);
}); 