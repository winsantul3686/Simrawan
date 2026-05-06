<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksiList = Transaksi::with(['customer', 'stokIkan'])
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        return view('transaksi.index', compact('transaksiList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Dikirim,Selesai,Dibatalkan',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => $request->status]);

        return redirect()->route('transaksi.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}