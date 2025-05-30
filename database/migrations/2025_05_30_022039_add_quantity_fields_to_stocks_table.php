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
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('quantity_out')->after('quantity')->default(0); // Jumlah Barang Keluar
            $table->integer('total_price_after')->after('quantity_out')->default(0); // Jumlah Barang Setelah Proses
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['quantity_out', 'total_price_after']);
        });
    }
};
