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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail_penjualan');
            $table->unsignedBigInteger('pupuk_id_pupuk');
            $table->unsignedBigInteger('penjualan_id_penjualan');
            $table->decimal('harga_jual', 12, 2);
            $table->integer('jumlah');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->foreign('pupuk_id_pupuk')->references('id_pupuk')->on('pupuk');
            $table->foreign('penjualan_id_penjualan')->references('id_penjualan')->on('penjualan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
