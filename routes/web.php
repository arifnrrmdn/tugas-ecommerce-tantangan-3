<?php

use App\Http\Controllers\ProdukController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ariev', function () {
    return view('view-belajar');
});


// Menggunakan array assosiatif
Route::get('/produk/create', [ProdukController::class, 'create']);

Route::post('/produk/create', [ProdukController::class, 'store']);


// Menggunakan array assosiatif
Route::get('/belajar-kirim-data', [ProdukController::class, 'index']);

// Menggunakan compact
Route::get('/belajar-kirim-data-2', function () {
    $name = "Dudung Surudung";
    $jk = "Laki-laki";
    $role = "ERP Technical Developer";
    return view('view-data', compact('name', 'jk', 'role'));
});

Route::get('/route-biodata', function () {

    $data_mahasiswa['nim'] = 10522014;
    $data_mahasiswa['nama_lengkap'] = 'Arif N Ramadhan';
    $data_mahasiswa['kelas'] = 'IS-1';
    $data_mahasiswa['jurusan'] = 'Sistem Informasi';
    $data_mahasiswa['alamat'] = 'Jl. Jenderal Sudirman, Citepus, Kec. Pelabuhanratu, Kabupaten Sukabumi, Jawa Barat 43364';
    
    return view('view-biodata', $data_mahasiswa);
});

Route::get('/route-dosen', function () {

    $nip = '4127.70.26.124';
    $nidn = "0423019401";
    $nama_lengkap = 'Ferry Stephanus Suwita, S.Kom., M.T.';
    $tempat_lahir = 'bandung';
    $tanggal_lahir = '14-Desember-1995';

    return view('view-dosen', compact('nip', 'nidn', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir'));
});

Route::get('/route-produk', function () {
    $nama_produk = 'Vans Classic Slip On';
    $warna = 'Hitam';
    $ukuran = '40';
    $jumlah = 90;
    
    return view('view-produk', compact('nama_produk', 'warna', 'ukuran', 'jumlah'));
});
