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
        Schema::create('md_goods', function (Blueprint $table) {
            $table->id('id_mdgoods');
            $table->datetime('created_mdgoods');
            $table->integer('id_user');
            $table->string('code_mdgoods');
            $table->string('name_mdgoods');
            $table->integer('idcategory_mdgoods');
            $table->integer('idunit_mdgoods');
            $table->integer('purchase_price_mdgoods');
            $table->integer('selling_price_mdgoods');
            $table->integer('idsupplier_mdgoods');
            $table->string('code_supplier_mdgoods');
            $table->integer('stock_mdgoods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_goods');
    }
};
