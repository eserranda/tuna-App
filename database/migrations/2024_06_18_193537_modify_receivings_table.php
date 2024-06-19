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
        Schema::table('receivings', function (Blueprint $table) {
            $table->unsignedBigInteger('id_supplier')->after('id')->nullable();
            $table->foreign('id_supplier')->references('id')->on('suppliers')->cascadeOnUpdate()->nullOnDelete();
            $table->dropColumn('nama');  // Menghapus kolom 'nama' jika sudah ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receivings', function (Blueprint $table) {
            $table->dropForeign(['id_supplier']);
            $table->dropColumn('id_supplier');
            $table->string('nama')->nullable();  // Menambahkan kembali kolom 'nama' jika dibutuhkan saat rollback
        });
    }
};
