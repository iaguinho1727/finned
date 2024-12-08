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
        Schema::table('meals',function( Blueprint $table){
            $table->dropColumn('data');
            $table->foreignId('food_id')->constrained('foods');
            $table->foreignId('unit_id')->constrained('units');
            $table->integer('unit')->default(1);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
