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
        Schema::create('ult_survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guestbook_id')->constrained('guestbooks')->cascadeOnDelete();
            // 9 pertanyaan kuisioner ULT (nilai 1-4: Sangat Tidak Puas s/d Sangat Puas)
            $table->unsignedTinyInteger('q1')->comment('Kesesuaian persyaratan');
            $table->unsignedTinyInteger('q2')->comment('Kemudahan prosedur');
            $table->unsignedTinyInteger('q3')->comment('Kecepatan waktu pelayanan');
            $table->unsignedTinyInteger('q4')->comment('Tidak ada biaya / gratifikasi');
            $table->unsignedTinyInteger('q5')->comment('Kesesuaian produk layanan');
            $table->unsignedTinyInteger('q6')->comment('Kompetensi petugas');
            $table->unsignedTinyInteger('q7')->comment('Sikap petugas');
            $table->unsignedTinyInteger('q8')->comment('Kualitas sarana dan prasarana');
            $table->unsignedTinyInteger('q9')->comment('Penanganan pengaduan');
            $table->text('saran')->nullable()->comment('Saran dan masukan pengunjung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ult_survey_responses');
    }
};
