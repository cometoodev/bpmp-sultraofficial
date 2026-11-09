<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('standar_pelayanans', function (Blueprint $table) {
            $table->string('source_type', 30)->default('file')->after('title'); // 'file' atau 'drive_link'
            $table->string('file_extension', 20)->default('pdf')->after('source_type'); // 'pdf', 'doc', 'docx', 'link'
            $table->string('category', 100)->default('Umum')->after('file_extension'); // 'Umum', 'Pendidikan', 'Perizinan', 'Pengaduan', 'Kepegawaian', dll.
            $table->unsignedInteger('order_position')->default(0)->after('category');
            $table->boolean('is_active')->default(true)->after('order_position');
            $table->unsignedInteger('download_count')->default(0)->after('is_active');
        });

        // Inisialisasi order_position berdasarkan id yang sudah ada
        DB::table('standar_pelayanans')->orderBy('id')->get()->each(function ($item, $idx) {
            DB::table('standar_pelayanans')->where('id', $item->id)->update([
                'order_position' => $idx + 1,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('standar_pelayanans', function (Blueprint $table) {
            $table->dropColumn([
                'source_type',
                'file_extension',
                'category',
                'order_position',
                'is_active',
                'download_count',
            ]);
        });
    }
};
