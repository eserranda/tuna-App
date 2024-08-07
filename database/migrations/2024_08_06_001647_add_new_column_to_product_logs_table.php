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
        Schema::table('product_logs', function (Blueprint $table) {
            $table->string('ilc')->after('id');

            $table->unsignedBigInteger('id_produk')->after('ilc');
            $table->foreign('id_produk')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('no_ikan')->after('ilc');
            $table->string('customer_group')->after('no_ikan');
            $table->string('berat')->after('customer_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_logs', function (Blueprint $table) {
            $table->dropColumn(['ilc', 'id_produk', 'no_ikan', 'customer_group', 'berat']);
        });
    }
};
