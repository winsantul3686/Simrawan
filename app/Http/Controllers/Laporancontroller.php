<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\StokIkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // Data Laporan Keuangan
        $totalPemasukan   = Transaksi::where('status', 'Selesai')->sum('total_harga');
        $totalPengeluaran = Pengeluaran::sum('jumlah');

        // Laba = harga jual (total_harga) dikurangi modal (harga_modal × jumlah) per transaksi
        // Gunakan prefix tabel 'transaksis.status' agar tidak ambigu saat JOIN dengan stok_ikans (yg juga punya kolom 'status')
        $totalModal = Transaksi::where('transaksis.status', 'Selesai')
            ->join('stok_ikans', 'transaksis.stok_ikan_id', '=', 'stok_ikans.id')
            ->selectRaw('SUM(stok_ikans.harga_modal * transaksis.jumlah) as total_modal')
            ->value('total_modal') ?? 0;

        $laba = $totalPemasukan - $totalModal;
        $pengeluarans     = Pengeluaran::orderBy('tanggal', 'desc')->get();
        $pemasukans       = Transaksi::with(['customer', 'stokIkan'])
                                     ->where('status', 'Selesai')
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        return view('laporan.index', compact(
            'totalPemasukan', 'totalPengeluaran', 'totalModal', 'laba', 'pengeluarans', 'pemasukans'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'jumlah'    => 'required|numeric|min:0',
        ]);

        Pengeluaran::create($request->only('tanggal', 'deskripsi', 'kategori', 'jumlah'));

        return redirect()->route('laporan.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Pengeluaran::findOrFail($id)->delete();
        return redirect()->route('laporan.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}