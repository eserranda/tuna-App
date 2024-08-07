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
            $table->string('whole')->nullable()->change();
            $table->string('uji_lab')->nullable()->change();
            $table->string('tekstur')->nullable()->change();
            $table->string('bau')->nullable()->change();
            $table->string('es')->nullable()->change();
            $table->string('suhu')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receiving_checkings', function (Blueprint $table) {
            $table->string('whole')->change();
            $table->string('uji_lab')->change();
            $table->string('tekstur')->change();
            $table->string('bau')->change();
            $table->string('es')->change();
            $table->string('suhu')->change();
        });
    }
};
