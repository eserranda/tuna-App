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
        Schema::create('packing_checkings', function (Blueprint $table) {
            $table->id();
            $table->string('ilc')->nullable();
            $table->string('uji_lab')->nullable();
            $table->string('penampakan')->nullable();
            $table->string('bau')->nullable();
            $table->string('es')->nullable();
            $table->string('suhu')->nullable();
            $table->string('parasite')->nullable();
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_checkings');
    }
};