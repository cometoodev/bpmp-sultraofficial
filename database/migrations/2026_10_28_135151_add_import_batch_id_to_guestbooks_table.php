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
        Schema::table('guestbooks', function (Blueprint $table) {
            $table->string('import_batch_id')->nullable()->after('jenis_layanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guestbooks', function (Blueprint $table) {
            $table->dropColumn('import_batch_id');
        });
    }
};
