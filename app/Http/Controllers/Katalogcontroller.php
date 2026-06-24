<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KatalogProduk;
use App\Models\StokIkan;

class KatalogController extends Controller
{
    public function index()
    {
        $katalogList = KatalogProduk::with('stokIkan')->orderBy('created_at', 'desc')->get();
        $stokList    = StokIkan::where('status', 'Tersedia')->get();
        return view('katalog.index', compact('katalogList', 'stokList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_ikan_id' => 'required|exists:stok_ikans,id',
            'deskripsi'    => 'nullable|string',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $file   = $request->file('gambar');
            $gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $gambar);
        }

        KatalogProduk::create([
            'stok_ikan_id' => $request->stok_ikan_id,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => $gambar,
        ]);

        return redirect()->route('katalog.index')->with('success', 'Katalog produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $katalog = KatalogProduk::findOrFail($id);

        $gambar = $katalog->gambar;
        if ($request->hasFile('gambar')) {
            $file   = $request->file('gambar');
            $gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $gambar);
        }

        $katalog->update([
            'stok_ikan_id' => $request->stok_ikan_id ?? $katalog->stok_ikan_id,
            'deskripsi'    => $request->deskripsi ?? $katalog->deskripsi,
            'gambar'       => $gambar,
        ]);

        return redirect()->route('katalog.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KatalogProduk::findOrFail($id)->delete();
        return redirect()->route('katalog.index')->with('success', 'Katalog produk berhasil dihapus!');
    }
}