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
            'status'             => 'required|in:Menunggu,Diproses,Dikirim,Selesai,Dibatalkan',
            'status_pembayaran'  => 'nullable|in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $data = [
            'status'   => $request->status,
            'is_read'  => false
        ];
        if ($request->has('status_pembayaran')) {
            $data['status_pembayaran'] = $request->status_pembayaran;
        }
        $transaksi->update($data);

        return redirect()->route('transaksi.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}