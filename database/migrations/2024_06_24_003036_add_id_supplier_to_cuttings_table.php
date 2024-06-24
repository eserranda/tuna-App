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
        Schema::table('cuttings', function (Blueprint $table) {
            $table->unsignedBigInteger('id_supplier')->after('id')->nullable();
            $table->foreign('id_supplier')->references('id')->on('suppliers')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuttings', function (Blueprint $table) {
            $table->dropColumn('id_supplier');
        });
    }
};
