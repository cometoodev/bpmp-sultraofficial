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
        if (! Schema::hasColumn('pages', 'html_content')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->longText('html_content')->nullable()->after('content');
            });

            DB::table('pages')->whereNull('html_content')->update([
                'html_content' => DB::raw('content'),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pages', 'html_content')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('html_content');
            });
        }
    }
};
