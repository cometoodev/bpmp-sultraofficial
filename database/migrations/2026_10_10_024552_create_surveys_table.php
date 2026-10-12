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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('period', 50)->default('Triwulan 1');
            $table->unsignedSmallInteger('year')->default(2026);
            $table->text('description')->nullable();
            $table->unsignedInteger('total_respondents')->default(0);
            $table->json('nrr_elements')->nullable(); // NRR U1..U9
            $table->json('nrt_elements')->nullable(); // NRT U1..U9
            $table->decimal('ikm_score', 6, 2)->nullable(); // SKM Final (skala 100)
            $table->string('ikm_service_quality', 5)->nullable(); // A, B, C, D
            $table->string('ikm_performance_category', 50)->nullable(); // Sangat Baik, Baik, Kurang Baik, Tidak Baik
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
