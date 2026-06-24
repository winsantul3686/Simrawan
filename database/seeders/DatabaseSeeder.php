<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'nama'       => 'SiMrawan',
            'username'   => 'admin',
            'password'   => md5('admin123'),
            'no_telp'    => '08123456789',
            'email'      => 'SiMrawan@email.com',
            'alamat'     => 'Jl. Raya Jember No. 123, Kecamatan Sumbersari, Kabupaten Jember, Jawa Timur',
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Stok Ikan
        DB::table('stok_ikans')->insert([
            ['jenis_ikan' => 'Lele', 'ukuran_sortasi' => '7-9 ekor/kg',  'jumlah_stok' => 120, 'harga_modal' => 22000, 'harga_jual' => 25000, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_ikan' => 'Lele', 'ukuran_sortasi' => '10-12 ekor/kg','jumlah_stok' => 165, 'harga_modal' => 18000, 'harga_jual' => 22000, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_ikan' => 'Lele', 'ukuran_sortasi' => '3-5 ekor/kg',  'jumlah_stok' => 80,  'harga_modal' => 18000, 'harga_jual' => 22000, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_ikan' => 'Nila', 'ukuran_sortasi' => '4-6 ekor/kg',  'jumlah_stok' => 60,  'harga_modal' => 20000, 'harga_jual' => 25000, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Katalog Produk
        DB::table('katalog_produks')->insert([
            ['stok_ikan_id' => 1, 'deskripsi' => 'Ikan lele segar kualitas super, dipanen langsung dari kolam.', 'gambar' => null, 'created_at' => now(), 'updated_at' => now()],
            ['stok_ikan_id' => 2, 'deskripsi' => 'Ikan lele segar kualitas super, dipanen langsung dari kolam.', 'gambar' => null, 'created_at' => now(), 'updated_at' => now()],
            ['stok_ikan_id' => 3, 'deskripsi' => 'Ikan lele segar kualitas super, dipanen langsung dari kolam.', 'gambar' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Customers
        DB::table('users')->insert([
            ['nama' => 'Ucun',   'no_telp' => '08111111111', 'email' => 'ucun@gmail.com',   'alamat' => 'Jember, depan kampus unej gang 10', 'password' => md5('password'), 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Caca',   'no_telp' => '08222222222', 'email' => 'caca@gmail.com',   'alamat' => 'Jember, Jl. Kalimantan No.5',         'password' => md5('password'), 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cici',   'no_telp' => '08333333333', 'email' => 'cici@gmail.com',   'alamat' => 'Jember, Perumahan Griya Asri Blok A',  'password' => md5('password'), 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Transaksi
        DB::table('transaksis')->insert([
            ['no_pesanan' => 'ORD-001', 'customer_id' => 1, 'stok_ikan_id' => 1, 'ukuran' => '7-9 ekor/kg', 'jumlah' => 3, 'total_harga' => 75000,  'alamat_pengiriman' => 'Jember, depan kampus unej gang 10', 'bukti_bayar' => null, 'tgl_upload' => now(), 'status' => 'Menunggu', 'created_at' => now(), 'updated_at' => now()],
            ['no_pesanan' => 'ORD-002', 'customer_id' => 2, 'stok_ikan_id' => 2, 'ukuran' => '10-12 ekor/kg','jumlah' => 5, 'total_harga' => 110000, 'alamat_pengiriman' => 'Jember, Jl. Kalimantan No.5',         'bukti_bayar' => null, 'tgl_upload' => now(), 'status' => 'Diproses', 'created_at' => now(), 'updated_at' => now()],
            ['no_pesanan' => 'ORD-003', 'customer_id' => 3, 'stok_ikan_id' => 1, 'ukuran' => '7-9 ekor/kg', 'jumlah' => 4, 'total_harga' => 100000, 'alamat_pengiriman' => 'Jember, Perumahan Griya Asri Blok A',  'bukti_bayar' => null, 'tgl_upload' => now(), 'status' => 'Selesai',  'created_at' => now(), 'updated_at' => now()],
        ]);

        // Notifikasi
        DB::table('notifikasis')->insert([
            ['judul' => 'Pesanan Baru #ORD-001', 'isi' => 'Customer Ucun melakukan pemesanan Lele 7-9 ekor/kg sebanyak 3 Kg.', 'tipe' => 'pesanan', 'status' => 'dibaca', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Pesanan Baru #ORD-002', 'isi' => 'Customer Caca melakukan pemesanan Lele 10-12 ekor/kg sebanyak 5 Kg.', 'tipe' => 'pesanan', 'status' => 'belum_dibaca', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Pesanan Baru #ORD-003', 'isi' => 'Customer Cici melakukan pemesanan Lele 7-9 ekor/kg sebanyak 4 Kg.', 'tipe' => 'pesanan', 'status' => 'dibaca', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Wishlist Baru', 'isi' => 'Customer Ucun menambahkan Nila 4-6 ekor/kg ke wishlist.', 'tipe' => 'wishlist', 'status' => 'belum_dibaca', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Wishlist Baru', 'isi' => 'Customer Caca menambahkan Nila 4-6 ekor/kg ke wishlist.', 'tipe' => 'wishlist', 'status' => 'dibaca', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Wishlist
        DB::table('wishlists')->insert([
            ['customer_id' => 1, 'stok_ikan_id' => 4, 'ukuran' => '4-6 ekor/kg', 'jumlah' => 3, 'tanggal_diminta' => now(), 'status' => 'Belum Tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['customer_id' => 2, 'stok_ikan_id' => 4, 'ukuran' => '4-6 ekor/kg', 'jumlah' => 2, 'tanggal_diminta' => now(), 'status' => 'Tersedia',       'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}