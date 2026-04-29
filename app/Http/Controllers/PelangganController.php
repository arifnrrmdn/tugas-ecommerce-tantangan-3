<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index()
    {
        $data = Pelanggan::latest()->get();
        return view('pelanggan.index', compact('data'));
    }

    public function create()
    {
        return view('pelanggan.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_hp' => 'required',
            'email' => 'required|email|unique:pelanggan,email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
        ];

        // ✅ Upload foto (FIX UTAMA DI SINI)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $filename = time() . '_' . $file->getClientOriginalName();

            // 🔥 WAJIB pakai disk public
            Storage::disk('public')->putFileAs('pelanggan', $file, $filename);

            $data['foto'] = $filename;
        }

        Pelanggan::create($data);

        return redirect('/pelanggan')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.form', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_hp' => 'required',
            'email' => 'required|email|unique:pelanggan,email,' . $id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
        ];

        // ✅ Upload foto baru
        if ($request->hasFile('foto')) {

            // 🔥 Hapus foto lama
            if ($pelanggan->foto && Storage::disk('public')->exists('pelanggan/'.$pelanggan->foto)) {
                Storage::disk('public')->delete('pelanggan/'.$pelanggan->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            Storage::disk('public')->putFileAs('pelanggan', $file, $filename);

            $data['foto'] = $filename;
        }

        $pelanggan->update($data);

        return redirect('/pelanggan')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // 🔥 Hapus foto dari storage
        if ($pelanggan->foto && Storage::disk('public')->exists('pelanggan/'.$pelanggan->foto)) {
            Storage::disk('public')->delete('pelanggan/'.$pelanggan->foto);
        }

        $pelanggan->delete();

        return redirect('/pelanggan')->with('success', 'Data berhasil dihapus');
    }
}