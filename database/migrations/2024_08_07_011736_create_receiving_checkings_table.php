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
        Schema::create('receiving_checkings', function (Blueprint $table) {
            $table->id();
            $table->string('whole');
            $table->string('uji_lab');
            $table->string('tekstur');
            $table->string('bau');
            $table->string('es');
            $table->string('suhu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiving_checkings');
    }
};
