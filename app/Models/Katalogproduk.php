<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KatalogProduk extends Model
{
    protected $table = 'katalog_produks';
    protected $fillable = ['stok_ikan_id', 'deskripsi', 'gambar'];

    public function stokIkan()
    {
        return $this->belongsTo(StokIkan::class, 'stok_ikan_id');
    }
}