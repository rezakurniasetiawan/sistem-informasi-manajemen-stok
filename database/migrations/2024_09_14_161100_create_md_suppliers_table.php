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
        Schema::create('md_suppliers', function (Blueprint $table) {
            $table->id('id_mdsupplier');
            $table ->datetime('created_mdsupplier');
            $table->integer('id_user');
            $table->string('code_mdsupplier');
            $table->string('name_mdsupplier');
            $table->string('address_mdsupplier');
            $table->string('email_mdsupplier');
            $table->string('phone_mdsupplier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_suppliers');
    }
};
