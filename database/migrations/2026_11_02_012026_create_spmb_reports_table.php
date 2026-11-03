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
        Schema::create('spmb_reports', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('spmb');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->text('message');
            $table->string('evidence_file')->nullable();
            $table->string('status')->default('pending'); // pending, processed, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_reports');
    }
};
