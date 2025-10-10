<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pembelian', function (Blueprint $table) {
            // tanggal_beli default ke hari ini, tapi bisa diubah user
            $table->date('tanggal_beli')->default(now())->after('bayar');

            // status pembelian (tertunda/lunas)
            $table->enum('status', ['tertunda', 'lunas'])->default('tertunda')->after('tanggal_beli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->dropColumn(['tanggal_beli', 'status']);
        });
    }
};
