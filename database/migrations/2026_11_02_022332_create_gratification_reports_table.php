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
        Schema::create('gratification_reports', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name');
            $table->string('nip')->default('0');
            $table->string('position');
            $table->string('activity_name');
            $table->date('activity_date')->nullable();
            $table->string('activity_location');

            // Layanan Gratis
            $table->text('free_services')->nullable(); // JSON array
            $table->date('service_date')->nullable();
            $table->string('service_provider_name')->default('0');
            $table->string('service_provider_position')->default('0');

            // Ole-ole / Bingkisan
            $table->text('gift_consumable_types')->nullable(); // JSON array
            $table->text('gift_non_consumable_desc')->nullable();
            $table->string('gift_giver_name')->nullable();
            $table->string('gift_giver_position')->nullable();
            $table->date('gift_received_date')->nullable();
            $table->string('follow_up_action')->nullable();

            // Bukti & Status
            $table->string('evidence_file')->nullable();
            $table->string('status')->default('pending'); // pending, verified, recorded

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gratification_reports');
    }
};
