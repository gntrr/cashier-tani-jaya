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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->unsignedBigInteger('users_id_users');
            $table->unsignedBigInteger('pemasok_id_pemasok');
            $table->string('kode_pembelian', 45);
            $table->integer('total_item')->nullable();
            $table->decimal('bayar', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->foreign('users_id_users')->references('id_users')->on('users');
            $table->foreign('pemasok_id_pemasok')->references('id_pemasok')->on('pemasok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
