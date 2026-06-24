<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokIkan;

class StokController extends Controller
{
    public function index()
    {
        $stokList = StokIkan::orderBy('created_at', 'desc')->get();
        return view('stok.index', compact('stokList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_ikan'     => 'required|string|max:100',
            'ukuran_sortasi' => 'required|string|max:50',
            'jumlah_stok'    => 'required|numeric|min:0',
            'harga_modal'    => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
        ]);

        $status = $request->jumlah_stok > 0 ? 'Tersedia' : 'Habis';

        StokIkan::create([
            'jenis_ikan'     => $request->jenis_ikan,
            'ukuran_sortasi' => $request->ukuran_sortasi,
            'jumlah_stok'    => $request->jumlah_stok,
            'harga_modal'    => $request->harga_modal,
            'harga_jual'     => $request->harga_jual,
            'status'         => $status,
        ]);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_ikan'     => 'required|string|max:100',
            'ukuran_sortasi' => 'required|string|max:50',
            'jumlah_stok'    => 'required|numeric|min:0',
            'harga_modal'    => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
        ]);

        $stok = StokIkan::findOrFail($id);
        $status = $request->jumlah_stok > 0 ? 'Tersedia' : 'Habis';

        $stok->update([
            'jenis_ikan'     => $request->jenis_ikan,
            'ukuran_sortasi' => $request->ukuran_sortasi,
            'jumlah_stok'    => $request->jumlah_stok,
            'harga_modal'    => $request->harga_modal,
            'harga_jual'     => $request->harga_jual,
            'status'         => $status,
        ]);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $stok = StokIkan::findOrFail($id);

        // Periksa apakah stok ikan ini sudah digunakan dalam transaksi (tidak boleh dihapus)
        if ($stok->transaksis()->exists()) {
            return redirect()->route('stok.index')->with('error', 'Stok tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        // Hapus wishlist yang merujuk ke stok ikan ini
        $stok->wishlists()->delete();

        // Hapus katalog produk yang merujuk ke stok ikan ini
        $stok->katalog()->delete();

        $stok->delete();
        return redirect()->route('stok.index')->with('success', 'Stok berhasil dihapus!');
    }
}