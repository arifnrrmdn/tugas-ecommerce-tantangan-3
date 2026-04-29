<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $result = Produk::all();
        return view('produk.index', compact('result'));
    }

    public function create()
    {
        return view('produk.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_produk' => 'required',
            'harga_produk' => 'required|numeric|min:1000',
            'nama_produk' => 'required|min:3|max:100',
            'stok' => 'required|numeric|min:0'
        ]);

        $input = $request->all();

        if ($request->hasFile('foto_produk')) {
            $fileName = time().'_'.$request->foto_produk->getClientOriginalName();
            $request->foto_produk->storeAs('produk', $fileName);
            $input['foto_produk'] = $fileName;
        }

        Produk::create($input);

        return redirect('/produk')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.form', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'kategori_produk' => 'required',
            'harga_produk' => 'required|numeric|min:1000',
            'nama_produk' => 'required|min:3|max:100',
            'stok' => 'required|numeric|min:0'
        ]);

        $input = $request->all();

        if ($request->hasFile('foto_produk')) {
            $fileName = time().'_'.$request->foto_produk->getClientOriginalName();
            // $request->foto_produk->storeAs('produk', $fileName);
            $request->foto_produk->storeAs('public/produk', $fileName);
            
            $input['foto_produk'] = $fileName;
        }

        $produk->update($input);

        return redirect('/produk')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect('/produk')->with('success', 'Data berhasil dihapus');
    }
}