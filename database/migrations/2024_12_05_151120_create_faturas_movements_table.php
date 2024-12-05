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
        Schema::create('faturas_movements', function (Blueprint $table) {
            $table->foreignId('fatura_id')->constrained('faturas');
            $table->foreignId('movement_id')->constrained('movements');
            $table->primary(['fatura_id','movement_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas_movements');
    }
};
