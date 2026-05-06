<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pesanan');

        $notifPesanan  = Notifikasi::where('tipe', 'pesanan')->orderBy('created_at', 'desc')->get();
        $notifWishlist = Notifikasi::where('tipe', 'wishlist')->orderBy('created_at', 'desc')->get();

        // Tandai semua yang sedang ditampilkan sebagai dibaca
        Notifikasi::where('tipe', $tab)->where('status', 'belum_dibaca')->update(['status' => 'dibaca']);

        return view('notifikasi.index', compact('notifPesanan', 'notifWishlist', 'tab'));
    }
}