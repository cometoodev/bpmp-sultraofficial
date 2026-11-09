<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_throttling_locks_after_three_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@bpmp.kemdikbud.go.id',
            'password' => Hash::make('CorrectPassword123!'),
        ]);

        // Attempt 1: Failed
        $response1 = $this->post('/login', [
            'email' => 'admin@bpmp.kemdikbud.go.id',
            'password' => 'WrongPassword1',
        ]);
        $response1->assertSessionHasErrors('email');

        // Attempt 2: Failed
        $response2 = $this->post('/login', [
            'email' => 'admin@bpmp.kemdikbud.go.id',
            'password' => 'WrongPassword2',
        ]);
        $response2->assertSessionHasErrors('email');

        // Attempt 3: Failed -> Locks out for 15 minutes (900 seconds)
        $response3 = $this->post('/login', [
            'email' => 'admin@bpmp.kemdikbud.go.id',
            'password' => 'WrongPassword3',
        ]);
        $response3->assertSessionHasErrors('email');

        // Attempt 4: Should be throttled with Indonesian error message
        $response4 = $this->post('/login', [
            'email' => 'admin@bpmp.kemdikbud.go.id',
            'password' => 'CorrectPassword123!',
        ]);
        $response4->assertSessionHasErrors('email');
        $errorMessage = session('errors')->first('email');
        $this->assertStringContainsString('15 menit', $errorMessage);
    }

    public function test_superadmin_can_access_user_management_and_editor_is_forbidden(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        // Superadmin access
        $this->actingAs($superadmin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Manajemen Pengguna');

        // Editor access should be forbidden (403)
        $this->actingAs($editor)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_user_deletion_safely_reassigns_posts_and_media_to_active_admin(): void
    {
        $admin = User::factory()->create(['role' => 'superadmin']);
        $targetUser = User::factory()->create(['role' => 'editor']);

        $category = Category::create([
            'name' => 'Kabar BPMP',
            'slug' => 'kabar-bpmp',
        ]);

        $post = Post::create([
            'title' => 'Judul Berita Test',
            'slug' => 'judul-berita-test',
            'category_id' => $category->id,
            'author_id' => $targetUser->id,
            'content' => 'Konten berita.',
            'status' => 'published',
        ]);

        $media = Media::create([
            'filename' => 'banner-test.jpg',
            'path' => 'media/banner-test.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 2048,
            'uploaded_by' => $targetUser->id,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $targetUser))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);

        // Verify post and media are preserved and reassigned to active admin
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'author_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'uploaded_by' => $admin->id,
        ]);
    }

    public function test_admin_cannot_delete_themselves_or_the_last_superadmin(): void
    {
        $admin = User::factory()->create(['role' => 'superadmin']);

        // Delete self attempt
        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_update_profile_and_verifies_current_password(): void
    {
        $admin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'old_admin@bpmp.kemdikbud.go.id',
            'password' => Hash::make('CurrentPassword123!'),
        ]);

        // Attempt password change without current_password
        $responseFail = $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => 'New Name',
                'email' => 'old_admin@bpmp.kemdikbud.go.id',
                'password' => 'NewSecretPassword123!',
                'password_confirmation' => 'NewSecretPassword123!',
            ]);
        $responseFail->assertSessionHasErrors('current_password');

        // Valid update with current_password
        $responseSuccess = $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => 'Administrator Baru BPMP',
                'email' => 'new_admin@bpmp.kemdikbud.go.id',
                'current_password' => 'CurrentPassword123!',
                'password' => 'NewSecretPassword123!',
                'password_confirmation' => 'NewSecretPassword123!',
            ]);
        $responseSuccess->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHas('success');

        $admin->refresh();
        $this->assertEquals('Administrator Baru BPMP', $admin->name);
        $this->assertEquals('new_admin@bpmp.kemdikbud.go.id', $admin->email);
        $this->assertTrue(Hash::check('NewSecretPassword123!', $admin->password));
    }

    public function test_public_pages_track_visitors_and_footer_displays_metrics(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Live Traffic Monitor')
            ->assertSee('Sedang Online')
            ->assertSee('Hari Ini')
            ->assertSee('Total Kunjungan');

        // Verify visitor log is created
        $log = VisitorLog::first();
        $this->assertNotNull($log);
        $this->assertEquals(today()->toDateString(), $log->visited_date->toDateString());
    }
}
