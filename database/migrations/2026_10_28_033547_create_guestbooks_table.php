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
        Schema::create('guestbooks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin', 10); // L / P
            $table->unsignedTinyInteger('usia');
            $table->string('telepon', 20)->nullable();
            $table->string('pendidikan', 30);          // SD, SMP, SMA, D1-D3, S1, S2, S3
            $table->string('pekerjaan', 50);
            $table->string('status_kepegawaian', 30);  // PNS, Non-PNS, Swasta, dll.
            $table->string('asal_instansi');
            $table->string('asal_kabupaten', 100);
            $table->string('jenis_layanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guestbooks');
    }
};
