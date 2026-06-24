<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\KatalogProduk;

class ProdukController extends Controller
{
    public function index()
    {
        $produkList = KatalogProduk::with('stokIkan')
                        ->whereHas('stokIkan')
                        ->orderByRaw('(SELECT jumlah_stok FROM stok_ikans WHERE stok_ikans.id = katalog_produks.stok_ikan_id) = 0 ASC')
                        ->orderBy('created_at', 'desc')
                        ->get();

        $allStok = \App\Models\StokIkan::all()->groupBy('jenis_ikan');

        return view('customer.produk', compact('produkList', 'allStok'));
    }
}