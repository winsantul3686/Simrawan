<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak'])
                  ->default('Menunggu Konfirmasi')
                  ->after('bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });
    }
};
