<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Kategori::withCount('produk');

        if ($search) {
            $query->where('nama_kategori', 'LIKE', "%$search%");
        }

        $result = $query->paginate(10)->withQueryString();
        return view('kategori.index', compact('result', 'search'));
    }

    public function create()
    {
        return view('kategori.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|min:2|max:100|unique:kategori,nama_kategori',
        ]);

        Kategori::create($request->only('nama_kategori'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.form', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|min:2|max:100|unique:kategori,nama_kategori,' . $id,
        ]);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cegah hapus jika masih ada produk terkait
        if ($kategori->produk()->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
