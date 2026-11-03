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
        Schema::create('standar_pelayanans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path'); // Path file PDF di storage
            $table->string('file_size'); // Ukuran file otomatis dari backend (misal: "2.45 MB")
            $table->timestamp('uploaded_at'); // Tanggal upload murni dari backend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_pelayanans');
    }
};
