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
        Schema::table('receiving_checkings', function (Blueprint $table) {
            $table->string('ilc')->after('id')->nullable();
            $table->string('hasil')->after('suhu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receiving_checkings', function (Blueprint $table) {
            $table->dropColumn(['ilc', 'suhu']);
        });
    }
};
