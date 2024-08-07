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
            $table->string('checking')->nullable()->after('ekspor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuttings', function (Blueprint $table) {
            $table->dropColumn('checking');
        });
    }
};
