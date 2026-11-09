<?php

namespace Tests\Feature;

use App\Models\SocialIntegration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_active_social_media_and_fallback_card(): void
    {
        // Migrasi sudah melakukan pre-seed untuk instagram, tiktok, youtube
        SocialIntegration::where('platform', 'instagram')->update([
            'username' => 'bpmpsultra',
            'profile_url' => 'https://instagram.com/bpmpsultra',
            'embed_code' => '<div class="elfsight-app-instagram"></div>',
            'is_active' => true,
        ]);

        SocialIntegration::where('platform', 'tiktok')->update([
            'username' => 'bpmp.sultra',
            'profile_url' => 'https://tiktok.com/@bpmp.sultra',
            'embed_code' => null, // empty embed code should trigger fallback card
            'is_active' => true,
        ]);

        SocialIntegration::where('platform', 'youtube')->update([
            'username' => 'BPMPSultraOfficial',
            'profile_url' => 'https://youtube.com/@BPMPSultraOfficial',
            'embed_code' => null,
            'is_active' => false, // inactive platform should not appear
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Terhubung dengan Kami');
        $response->assertSee('Instagram');
        $response->assertSee('TikTok');
        // Active embed code
        $response->assertSee('elfsight-app-instagram', false);
        // Fallback card for TikTok
        $response->assertSee('@bpmp.sultra');
        $response->assertSee('Lihat Konten di TikTok');
        // Inactive YouTube CTA button should not be visible
        $response->assertDontSee('Buka Channel YouTube');
    }

    public function test_admin_can_access_social_media_settings_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.social.index'));

        $response->assertStatus(200);
        $response->assertSee('Integrasi Media Sosial');
        $response->assertSee('Simpan Perubahan Instagram');
        $response->assertSee('Simpan Perubahan TikTok');
        $response->assertSee('Simpan Perubahan YouTube');
    }

    public function test_admin_can_update_social_integration(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $social = SocialIntegration::where('platform', 'instagram')->first();

        $response = $this->actingAs($admin)->put(route('admin.social.update', $social), [
            'username' => 'bpmp_sultra_resmi',
            'profile_url' => 'https://instagram.com/bpmp_sultra_resmi',
            'embed_code' => '<div class="elfsight-app-new"></div>',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.social.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('social_integrations', [
            'id' => $social->id,
            'username' => 'bpmp_sultra_resmi',
            'profile_url' => 'https://instagram.com/bpmp_sultra_resmi',
            'embed_code' => '<div class="elfsight-app-new"></div>',
            'is_active' => true,
        ]);
    }
}
