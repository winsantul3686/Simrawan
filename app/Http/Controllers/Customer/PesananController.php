<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\StokIkan;
use App\Models\Notifikasi;

class PesananController extends Controller
{
    // Simpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'stok_ikan_id'      => 'required|exists:stok_ikans,id',
            'jumlah'            => 'required|integer|min:1',
            'total_harga'       => 'required|numeric',
            'alamat_pengiriman' => 'required|string',
        ]);

        $stok = StokIkan::findOrFail($request->stok_ikan_id);

        // Generate no pesanan: cth 01UCUNLELE
        $urutan    = str_pad(Transaksi::count() + 1, 2, '0', STR_PAD_LEFT);
        $namaSlug  = strtoupper(substr(preg_replace('/\s+/', '', session('customer_nama')), 0, 5));
        $ikanSlug  = strtoupper(substr(preg_replace('/\s+/', '', $stok->jenis_ikan), 0, 5));
        $no_pesanan = $urutan . $namaSlug . $ikanSlug;

        $transaksi = Transaksi::create([
            'no_pesanan'        => $no_pesanan,
            'customer_id'       => session('customer_id'),
            'stok_ikan_id'      => $request->stok_ikan_id,
            'ukuran'            => $stok->ukuran_sortasi,
            'jumlah'            => $request->jumlah,
            'total_harga'       => $request->total_harga,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'catatan'           => $request->catatan,
            'status'            => 'Menunggu',
        ]);

        // Buat notifikasi admin untuk pesanan baru
        $customerNama = session('customer_nama', 'Customer');
        Notifikasi::create([
            'judul'  => 'Pesanan Baru Masuk',
            'isi'    => "Customer {$customerNama} membuat pesanan baru ({$no_pesanan}) untuk {$stok->jenis_ikan} sebanyak {$request->jumlah} Kg.",
            'tipe'   => 'pesanan',
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('customer.pesanan.konfirmasi', $transaksi->id);
    }

    // Halaman konfirmasi + upload bukti
    public function konfirmasi($id)
    {
        $transaksi = Transaksi::with('stokIkan')->findOrFail($id);

        // Pastikan hanya milik customer ini
        if ($transaksi->customer_id !== session('customer_id')) {
            return redirect()->route('customer.produk')->with('error', 'Akses ditolak.');
        }

        // Tandai sebagai sudah dibaca karena customer sedang aktif melihat/memprosesnya
        $transaksi->update(['is_read' => true]);

        return view('customer.konfirmasi', compact('transaksi'));
    }

    // Upload bukti bayar
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->customer_id !== session('customer_id')) {
            return redirect()->route('customer.produk')->with('error', 'Akses ditolak.');
        }

        $file     = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $filename);

        $transaksi->update([
            'bukti_bayar' => $filename,
            'tgl_upload'  => now(),
        ]);

        return redirect()->route('customer.riwayat')->with('success', 'Bukti pembayaran berhasil diunggah!');
    }

    // Riwayat pesanan
    public function riwayat()
    {
        $pesananList = Transaksi::with('stokIkan')
                        ->where('customer_id', session('customer_id'))
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('customer.riwayat', compact('pesananList'));
    }

    // Batalkan pesanan
    public function batalkan($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->customer_id !== session('customer_id')) {
            return redirect()->route('customer.riwayat')->with('error', 'Akses ditolak.');
        }

        if (!in_array($transaksi->status, ['Menunggu'])) {
            return redirect()->route('customer.riwayat')->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $transaksi->update(['status' => 'Dibatalkan']);

        return redirect()->route('customer.riwayat')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}