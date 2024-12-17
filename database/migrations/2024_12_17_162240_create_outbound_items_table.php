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
        Schema::create('outbound_items', function (Blueprint $table) {
            $table->id('id_outbound_items'); // Primary Key
            $table->date('output_date'); // Tanggal Input
            $table->string('user', 100); // User
            $table->string('invoice_code', 50); // Kode Invoice
            $table->string('item_code', 50); // Kode Barang
            $table->string('item_name', 150); // Nama Barang
            $table->string('unit', 50); // Satuan
            $table->decimal('selling_price', 10, 2); // Harga Jual
            $table->integer('quantity'); // Jumlah Barang
            $table->decimal('total_price', 10, 2); // Total Harga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbound_items');
    }
};
