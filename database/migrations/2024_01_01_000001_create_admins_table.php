<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('no_telp')->nullable()->after('username');
            $table->string('email')->nullable()->after('no_telp');
            $table->text('alamat')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['no_telp', 'email', 'alamat']);
        });
    }
};