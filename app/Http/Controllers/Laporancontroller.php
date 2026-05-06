<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $totalPendapatan = Transaksi::where('status', 'Selesai')->sum('total_harga');
        $totalTransaksi  = Transaksi::count();
        $transaksiSelesai = Transaksi::where('status', 'Selesai')->count();

        $laporanBulanan = Transaksi::where('status', 'Selesai')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('SUM(total_harga) as total_pendapatan'),
                DB::raw('COUNT(*) as jumlah_transaksi')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        $rekapProduk = Transaksi::where('status', 'Selesai')
            ->with('stokIkan')
            ->select('stok_ikan_id', DB::raw('SUM(jumlah) as total_kg'), DB::raw('SUM(total_harga) as total_pendapatan'))
            ->groupBy('stok_ikan_id')
            ->orderBy('total_pendapatan', 'desc')
            ->get();

        return view('laporan.index', compact(
            'totalPendapatan', 'totalTransaksi', 'transaksiSelesai',
            'laporanBulanan', 'rekapProduk'
        ));
    }
}