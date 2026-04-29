<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

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
            'stok' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $input = $request->all();

        // ✅ Upload foto (konsisten ke public/produk)
        if ($request->hasFile('foto_produk')) {
            $path = $request->file('foto_produk')->store('produk', 'public');
            $input['foto_produk'] = basename($path);
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

        // ✅ Kalau ada foto baru
        if ($request->hasFile('foto_produk')) {

            // 🔥 Hapus foto lama
            if ($produk->foto_produk) {
                Storage::disk('public')->delete('produk/'.$produk->foto_produk);
            }

            // 🔥 Upload foto baru
            $path = $request->file('foto_produk')->store('produk', 'public');
            $input['foto_produk'] = basename($path);
        }

        // ❗ Kalau tidak upload → foto lama tetap aman

        $produk->update($input);

        return redirect('/produk')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // ✅ Hapus foto juga
        if ($produk->foto_produk) {
            Storage::disk('public')->delete('produk/'.$produk->foto_produk);
        }

        $produk->delete();

        return redirect('/produk')->with('success', 'Data berhasil dihapus');
    }
}