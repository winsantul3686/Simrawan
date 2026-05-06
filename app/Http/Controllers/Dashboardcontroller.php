<?php

namespace App\Http\Controllers;

use App\Models\StokIkan;
use App\Models\Transaksi;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenjualan   = Transaksi::where('status', 'Selesai')->sum('total_harga');
        $jumlahPesanan    = Transaksi::count();
        $jumlahCustomer   = Customer::count();
        $totalStok        = StokIkan::sum('jumlah_stok');

        $stokTersedia = StokIkan::where('status', 'Tersedia')
                                ->orderBy('jumlah_stok', 'desc')
                                ->get();

        // Penjualan per bulan (6 bulan terakhir)
        $penjualanBulanan = Transaksi::where('status', 'Selesai')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return view('layouts.dashboard', compact(
            'totalPenjualan', 'jumlahPesanan', 'jumlahCustomer',
            'totalStok', 'stokTersedia', 'penjualanBulanan'
        ));
    }
}