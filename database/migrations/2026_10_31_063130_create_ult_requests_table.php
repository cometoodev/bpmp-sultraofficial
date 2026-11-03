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
        Schema::create('ult_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 32)->unique();
            $table->enum('layanan_type', ['online', 'tatap_muka', 'keliling'])->index();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('profesi')->nullable();
            $table->string('instansi')->nullable();
            $table->string('kategori')->nullable()->index();
            $table->text('keperluan')->nullable();
            $table->string('dokumen_path')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending')->index();
            $table->text('catatan_petugas')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ult_requests');
    }
};
