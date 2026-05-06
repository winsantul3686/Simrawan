<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokIkan extends Model
{
    protected $table = 'stok_ikans';
    protected $fillable = ['jenis_ikan', 'ukuran_sortasi', 'jumlah_stok', 'harga_modal', 'harga_jual', 'status'];

    public function katalog()
    {
        return $this->hasOne(KatalogProduk::class, 'stok_ikan_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'stok_ikan_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'stok_ikan_id');
    }
}