<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsStageOneTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_homepage_and_berita_routes_still_work(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/berita')->assertStatus(200);
        $this->get('/berita/1')->assertStatus(200);
    }

    public function test_guest_is_redirected_to_login_when_accessing_admin_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/admin/pages')->assertRedirect('/login');
    }

    public function test_non_admin_user_is_forbidden_from_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }

    public function test_admin_user_can_access_dashboard_and_pages(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200)
            ->assertSee('CMS Dashboard');

        $this->actingAs($admin)
            ->get('/admin/pages')
            ->assertStatus(200)
            ->assertSee('Pages (Halaman Website)');
    }

    public function test_admin_can_create_and_edit_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $createResponse = $this->actingAs($admin)->post('/admin/pages', [
            'title' => 'Profil Singkat BPMP Sultra',
            'slug' => 'profil-singkat-bpmp-sultra',
            'content' => '<p>Konten profil uji coba BPMP Sultra.</p>',
            'status' => 'published',
            'meta_title' => 'Profil Singkat',
            'meta_description' => 'Deskripsi profil singkat',
        ]);

        $createResponse->assertRedirect('/admin/pages');

        $this->assertDatabaseHas('pages', [
            'slug' => 'profil-singkat-bpmp-sultra',
            'status' => 'published',
        ]);

        $page = Page::where('slug', 'profil-singkat-bpmp-sultra')->first();
        $this->assertNotNull($page);

        // Public dynamic route should work
        $this->get('/profil-singkat-bpmp-sultra')
            ->assertStatus(200)
            ->assertSee('Profil Singkat BPMP Sultra')
            ->assertSee('Konten profil uji coba BPMP Sultra.');

        // Edit page
        $updateResponse = $this->actingAs($admin)->put("/admin/pages/{$page->id}", [
            'title' => 'Profil Baru BPMP Sultra',
            'slug' => 'profil-singkat-bpmp-sultra',
            'content' => '<p>Konten yang diperbarui.</p>',
            'status' => 'published',
        ]);

        $updateResponse->assertRedirect('/admin/pages');
        $this->assertDatabaseHas('pages', [
            'title' => 'Profil Baru BPMP Sultra',
        ]);
    }

    public function test_draft_page_cannot_be_viewed_by_guest_but_can_be_previewed_by_admin(): void
    {
        $page = Page::create([
            'title' => 'Halaman Rahasia Masih Draft',
            'slug' => 'halaman-rahasia',
            'content' => '<p>Belum boleh dilihat publik.</p>',
            'status' => 'draft',
        ]);

        // Guest accesses draft -> 404
        $this->get('/halaman-rahasia')->assertStatus(404);

        // Admin preview route -> 200
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get("/admin/pages/{$page->id}/preview")
            ->assertStatus(200)
            ->assertSee('MODE PRATINJAU (PREVIEW)')
            ->assertSee('Halaman Rahasia Masih Draft');
    }

    public function test_non_existent_slug_returns_404(): void
    {
        $this->get('/halaman-yang-tidak-ada-sama-sekali-12345')->assertStatus(404);
    }
}
