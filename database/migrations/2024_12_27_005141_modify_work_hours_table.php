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
        Schema::table('work_hours', function (Blueprint $table) {
            $table->integer('bussiness_days')->nullable();
            $table->float('bussiness_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_hours', function (Blueprint $table) {
            $table->dropColumn(['bussiness_days','bussiness_hours']);
        });
    }
};
