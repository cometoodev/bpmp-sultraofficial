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
        Schema::create('page_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('title');
            $table->string('source_type', 30)->default('file');
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->string('file_extension', 20)->nullable();
            $table->string('file_size', 50)->nullable();
            $table->string('category', 100)->nullable();
            $table->unsignedInteger('order_position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();

            $table->index(['page_id', 'is_active', 'order_position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_attachments');
    }
};
