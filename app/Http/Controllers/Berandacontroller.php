<?php

namespace App\Http\Controllers;

use App\Models\KatalogProduk;

class BerandaController extends Controller
{
    public function index()
    {
        if (session('customer_id')) {
            return redirect()->route('customer.produk');
        }
        if (session('admin_id')) {
            return redirect()->route('dashboard');
        }

        $produkUnggulan = KatalogProduk::with('stokIkan')
            ->whereHas('stokIkan', fn($q) => $q->where('status', 'Tersedia'))
            ->latest()
            ->take(3)
            ->get();

        return view('layouts.beranda', compact('produkUnggulan'));
    }
}