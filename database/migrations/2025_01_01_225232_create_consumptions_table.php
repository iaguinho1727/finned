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
        Schema::disableForeignKeyConstraints();

        Schema::create('consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumable_id')->constrained('consumables');
            $table->foreignId('consumable_unit_id')->constrained('units');
            $table->float('consumable_unit_quantity');
            $table->float('hours_consumed')->nullable();
            $table->string('comodo')->nullable();
            $table->string('casa')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumptions');
    }
};
