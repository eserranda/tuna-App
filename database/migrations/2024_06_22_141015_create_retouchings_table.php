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
        Schema::create('retouchings', function (Blueprint $table) {
            $table->id();
            $table->string('ilc');
            $table->string('ilc_cutting');
            $table->unsignedBigInteger('id_supplier')->nullable();


            $table->date('tanggal');
            $table->string('customer_grup');
            $table->decimal('berat', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retouchings');
    }
};
