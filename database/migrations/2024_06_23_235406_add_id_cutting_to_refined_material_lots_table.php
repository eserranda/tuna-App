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
        Schema::table('refined_material_lots', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cutting')->after('id')->nullable();
            // Tambahkan foreign key baru
            $table->foreign('id_cutting')->references('id')->on('cuttings')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refined_material_lots', function (Blueprint $table) {
            $table->dropColumn('id_cutting');
        });
    }
};
