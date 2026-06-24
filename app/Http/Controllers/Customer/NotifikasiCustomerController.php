<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Wishlist;

class NotifikasiCustomerController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pesanan');

        // Notifikasi dari status pesanan customer ini
        $notifPesanan = Transaksi::with('stokIkan')
                        ->where('customer_id', session('customer_id'))
                        ->orderBy('updated_at', 'desc')
                        ->get()
                        ->map(function ($t) {
                            $judul = match($t->status) {
                                'Diproses'   => 'Pesanan Sedang Diproses',
                                'Dikirim'    => 'Pesanan Sedang Dikirim',
                                'Selesai'    => 'Pesanan Selesai',
                                'Dibatalkan' => 'Pesanan Dibatalkan',
                                default      => 'Pesanan Menunggu Konfirmasi',
                            };
                            $isi = match($t->status) {
                                'Diproses'   => "Pembelian produk {$t->stokIkan->jenis_ikan} sedang dalam proses dan akan segera dikirim ke {$t->alamat_pengiriman}.",
                                'Dikirim'    => "Pesanan {$t->no_pesanan} sedang dalam perjalanan ke alamat kamu.",
                                'Selesai'    => "Pesanan {$t->no_pesanan} telah selesai. Terima kasih sudah berbelanja!",
                                'Dibatalkan' => "Pesanan {$t->no_pesanan} telah dibatalkan.",
                                default      => "Pesanan {$t->no_pesanan} menunggu konfirmasi pembayaran dari admin.",
                            };
                            return (object)[
                                'id'         => $t->id,
                                'judul'      => $judul,
                                'isi'        => $isi,
                                'status'     => $t->is_read ? 'dibaca' : 'belum_dibaca',
                                'created_at' => $t->updated_at,
                            ];
                        });

        // Notifikasi dari wishlist customer ini
        $notifWishlist = Wishlist::with('stokIkan')
                        ->where('customer_id', session('customer_id'))
                        ->orderBy('updated_at', 'desc')
                        ->get()
                        ->map(function ($w) {
                            $tersedia = $w->status === 'Tersedia';
                            return (object)[
                                'id'         => $w->id,
                                'judul'      => $tersedia ? 'Stok Ikan Sudah Tersedia!' : 'Wishlist Ditambahkan',
                                'isi'        => $tersedia
                                    ? "Kabar baik! {$w->stokIkan->jenis_ikan} ukuran {$w->ukuran} yang kamu wishlist sudah tersedia. Segera pesan sekarang!"
                                    : "Wishlist {$w->stokIkan->jenis_ikan} ukuran {$w->ukuran} berhasil ditambahkan. Kami akan memberitahu kamu saat stok tersedia.",
                                'status'     => $w->is_read ? 'dibaca' : 'belum_dibaca',
                                'created_at' => $w->updated_at,
                            ];
                        });

        return view('customer.notifikasi', compact('notifPesanan', 'notifWishlist', 'tab'));
    }

    public function show($type, $id)
    {
        if ($type === 'pesanan') {
            $t = Transaksi::with('stokIkan')->where('customer_id', session('customer_id'))->findOrFail($id);
            $t->update(['is_read' => true]);
            $judul = match($t->status) {
                'Diproses'   => 'Pesanan Sedang Diproses',
                'Dikirim'    => 'Pesanan Sedang Dikirim',
                'Selesai'    => 'Pesanan Selesai',
                'Dibatalkan' => 'Pesanan Dibatalkan',
                default      => 'Pesanan Menunggu Konfirmasi',
            };
            $isi = match($t->status) {
                'Diproses'   => "Pembelian produk {$t->stokIkan->jenis_ikan} sedang dalam proses dan akan segera dikirim ke {$t->alamat_pengiriman}.",
                'Dikirim'    => "Pesanan {$t->no_pesanan} sedang dalam perjalanan ke alamat kamu.",
                'Selesai'    => "Pesanan {$t->no_pesanan} telah selesai. Terima kasih sudah berbelanja!",
                'Dibatalkan' => "Pesanan {$t->no_pesanan} telah dibatalkan.",
                default      => "Pesanan {$t->no_pesanan} menunggu konfirmasi pembayaran dari admin.",
            };
            $notif = (object)[
                'judul' => $judul,
                'isi' => $isi,
                'date' => \Carbon\Carbon::parse($t->updated_at)->format('d F Y'),
                'time' => \Carbon\Carbon::parse($t->updated_at)->format('H.i'),
            ];
        } else {
            $w = Wishlist::with('stokIkan')->where('customer_id', session('customer_id'))->findOrFail($id);
            $w->update(['is_read' => true]);
            $tersedia = $w->status === 'Tersedia';
            $judul = $tersedia ? 'Stok Ikan Sudah Tersedia!' : 'Wishlist Ditambahkan';
            $isi = $tersedia
                ? "Kabar baik! {$w->stokIkan->jenis_ikan} ukuran {$w->ukuran} yang kamu wishlist sudah tersedia. Segera pesan sekarang!"
                : "Wishlist {$w->stokIkan->jenis_ikan} ukuran {$w->ukuran} berhasil ditambahkan. Kami akan memberitahu kamu saat stok tersedia.";
            $notif = (object)[
                'judul' => $judul,
                'isi' => $isi,
                'date' => \Carbon\Carbon::parse($w->updated_at)->format('d F Y'),
                'time' => \Carbon\Carbon::parse($w->updated_at)->format('H.i'),
            ];
        }

        return view('customer.notifikasi_detail', compact('notif', 'type'));
    }

    public function baca($id)
    {
        // Placeholder — bisa dikembangkan jika nanti ada tabel notifikasi per customer
        return redirect()->route('customer.notifikasi');
    }
}