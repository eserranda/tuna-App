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
            $table->string('ilc_cutting')->after('id_cutting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refined_material_lots', function (Blueprint $table) {
            $table->dropColumn('ilc_cutting');
        });
    }
};
