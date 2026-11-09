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
        Schema::create('social_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // instagram, tiktok, youtube
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('profile_url')->nullable();
            $table->longText('embed_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Seed default platforms
        DB::table('social_integrations')->insert([
            [
                'platform' => 'instagram',
                'name' => 'Instagram',
                'username' => '@bpmpsultra',
                'profile_url' => 'https://www.instagram.com/bpmpsultra/',
                'embed_code' => null,
                'is_active' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'tiktok',
                'name' => 'TikTok',
                'username' => '@bpmp.sulawesitenggara',
                'profile_url' => 'https://www.tiktok.com/@bpmp.sulawesitenggara',
                'embed_code' => null,
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'youtube',
                'name' => 'YouTube',
                'username' => '@bpmpsultra',
                'profile_url' => 'https://www.youtube.com/@bpmpsultra',
                'embed_code' => null,
                'is_active' => true,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_integrations');
    }
};
