<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function create()
    {
        return view('produk.form');
    }

    public function store(Request $request)
    {   
        $rules = [
            'kategori_produk' => 'required',
            'harga_produk' => 'required|numeric|min:1000',
            'nama_produk' => 'required|min:3|max:100',
            'stok' => 'required|numeric|min:0'
        ];

        // Validasi data
        $validated = $request->validate($rules);

        // Kirim ke view
        return view('produk.show', [
            'data' => $validated
        ]);
    }

    public function index()
    {
        $data = [
            'name' => 'Ariev',
            'jk' => 'Laki-laki',
            'role' => 'ERP Consultant'
        ];

        return view('view-data', $data);
    }
}