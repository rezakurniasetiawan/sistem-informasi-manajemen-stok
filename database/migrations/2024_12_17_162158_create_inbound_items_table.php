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
        Schema::create('inbound_items', function (Blueprint $table) {
            $table->id('id_inbound_items'); // Primary Key
            $table->datetime('input_date'); // Tanggal Input
            $table->string('user', 100); // User
            $table->string('invoice_code', 50); // Kode Invoice
            $table->string('item_code', 50); // Kode Barang
            $table->string('item_name', 150); // Nama Barang
            $table->string('unit', 50); // Satuan
            $table->string('supplier_code', 50); // Kode Supplier
            $table->string('supplier_name', 150); // Nama Supplier
            $table->integer('purchase_price'); // Harga Beli
            $table->integer('quantity'); // Jumlah Barang
            $table->integer('total_price'); // Total Harga
            $table->enum('type', ['inbound', 'outbound']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_items');
    }
};
