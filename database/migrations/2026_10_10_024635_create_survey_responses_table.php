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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->cascadeOnDelete();
            $table->string('respondent_name')->nullable();
            $table->unsignedSmallInteger('respondent_age')->nullable();
            $table->string('respondent_job')->nullable();
            $table->unsignedTinyInteger('u1');
            $table->unsignedTinyInteger('u2');
            $table->unsignedTinyInteger('u3');
            $table->unsignedTinyInteger('u4');
            $table->unsignedTinyInteger('u5');
            $table->unsignedTinyInteger('u6');
            $table->unsignedTinyInteger('u7');
            $table->unsignedTinyInteger('u8');
            $table->unsignedTinyInteger('u9');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
