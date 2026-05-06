<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $fillable = [
        'no_pesanan', 'customer_id', 'stok_ikan_id', 'ukuran',
        'jumlah', 'total_harga', 'alamat_pengiriman',
        'bukti_bayar', 'tgl_upload', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function stokIkan()
    {
        return $this->belongsTo(StokIkan::class, 'stok_ikan_id');
    }
}