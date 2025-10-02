<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_satuan_kg_to_pupuk_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pupuk', function (Blueprint $table) {
            // pakai decimal biar bisa 0.5, 2.5, 5, 10, dst.
            $table->decimal('satuan_kg', 8, 3)->nullable()->default(1.000)->after('stok_pupuk');
        });
    }

    public function down(): void
    {
        Schema::table('pupuk', function (Blueprint $table) {
            $table->dropColumn('satuan_kg');
        });
    }
};
