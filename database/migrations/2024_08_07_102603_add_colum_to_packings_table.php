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
        Schema::table('packings', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer')->after('id');
            $table->foreign('id_customer')->references('id')->on('customers')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('id_produk')->after('id_customer');
            $table->foreign('id_produk')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();

            $table->date('tanggal')->after('id_produk');
            $table->string('kode')->after('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packings', function (Blueprint $table) {
            $table->dropForeign(['id_customer']);
            $table->dropForeign(['id_produk']);
            $table->dropColumn(['id_customer', 'id_produk', 'tanggal', 'kode']);
        });
    }
};
