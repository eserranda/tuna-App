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
        Schema::create('customer_products', function (Blueprint $table) {
            $table->id();
            $table->string('ilc');

            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('berat');
            $table->string('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_products');
    }
};
