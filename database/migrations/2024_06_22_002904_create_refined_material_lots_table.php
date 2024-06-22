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
        Schema::create('refined_material_lots', function (Blueprint $table) {
            $table->id();
            $table->decimal('berat', 5, 2);
            $table->string('no_ikan');
            $table->integer('no_loin');
            $table->string('grade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refined_material_lots');
    }
};
