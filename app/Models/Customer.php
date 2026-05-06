<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = ['nama', 'no_telp', 'email', 'alamat', 'password'];
    protected $hidden = ['password'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'customer_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }
}