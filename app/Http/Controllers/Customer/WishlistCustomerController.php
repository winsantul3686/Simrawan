<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\KatalogProduk;

class WishlistCustomerController extends Controller
{
    public function index()
    {
        $wishlistList = Wishlist::with('stokIkan')
                        ->where('customer_id', session('customer_id'))
                        ->orderBy('created_at', 'desc')
                        ->get();

        $produkList = KatalogProduk::with('stokIkan')->get();

        return view('customer.wishlist', compact('wishlistList', 'produkList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_ikan_id'   => 'required|exists:stok_ikans,id',
            'ukuran'         => 'required|string',
            'jumlah'         => 'required|integer|min:1',
        ]);


        $wishlist = Wishlist::create([
            'customer_id'    => session('customer_id'),
            'stok_ikan_id'   => $request->stok_ikan_id,
            'ukuran'         => $request->ukuran,
            'jumlah'         => $request->jumlah,
            'tanggal_diminta'=> now()->toDateString(),
            'status'         => 'Belum Tersedia',
        ]);

        // Buat notifikasi admin
        $stokIkan = \App\Models\StokIkan::find($request->stok_ikan_id);
        $jenisIkan = $stokIkan ? $stokIkan->jenis_ikan : 'Ikan';
        $customerNama = session('customer_nama', 'Customer');

        \App\Models\Notifikasi::create([
            'judul'  => 'Permintaan Wishlist Baru',
            'isi'    => "Customer {$customerNama} menambahkan {$jenisIkan} (Ukuran: {$request->ukuran}, Jumlah: {$request->jumlah} Kg) ke wishlist.",
            'tipe'   => 'wishlist',
            'status' => 'belum_dibaca',
        ]);

        // Redirect ke halaman sebelumnya atau wishlist
        $referer = $request->headers->get('referer', '');
        if (str_contains($referer, '/customer/produk') || str_contains($referer, 'produk')) {
            return redirect()->route('customer.produk')->with('success', 'Berhasil ditambahkan ke wishlist! ❤️');
        }
        return redirect()->route('customer.wishlist')->with('success', 'Wishlist berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        if ($wishlist->customer_id !== session('customer_id')) {
            return redirect()->route('customer.wishlist')->with('error', 'Akses ditolak.');
        }

        $wishlist->delete();

        return redirect()->route('customer.wishlist')->with('success', 'Wishlist berhasil dihapus!');
    }
}