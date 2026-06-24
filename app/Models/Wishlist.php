<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['customer_id', 'stok_ikan_id', 'ukuran', 'jumlah', 'tanggal_diminta', 'status', 'is_read'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function stokIkan()
    {
        return $this->belongsTo(StokIkan::class, 'stok_ikan_id');
    }
}