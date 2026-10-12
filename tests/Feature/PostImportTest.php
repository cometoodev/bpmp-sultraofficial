<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\PostCsvSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_csv_seeder_imports_posts_from_2025_onwards(): void
    {
        $this->seed(PostCsvSeeder::class);

        // Posts should have been imported
        $this->assertGreaterThan(0, Post::count());

        // Check all imported posts are from year 2025 or newer
        $oldestPost = Post::orderBy('published_at', 'asc')->first();
        $this->assertNotNull($oldestPost);
        $this->assertGreaterThanOrEqual(2025, (int) $oldestPost->published_at->format('Y'));

        // Check latest post
        $latestPost = Post::orderBy('published_at', 'desc')->first();
        $this->assertNotNull($latestPost);
        $this->assertGreaterThanOrEqual(2025, (int) $latestPost->published_at->format('Y'));

        // Check category relationship
        $this->assertNotNull($latestPost->category);

        // Check thumbnail_url accessor
        $this->assertNotEmpty($latestPost->thumbnail_url);
    }

    public function test_public_berita_page_displays_imported_posts(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Berita Terkini',
            'slug' => 'berita-terkini',
            'is_active' => true,
        ]);

        $post = Post::create([
            'title' => 'Kegiatan Bimtek BPMP Sultra 2025',
            'slug' => 'kegiatan-bimtek-bpmp-sultra-2025',
            'category_id' => $category->id,
            'author_id' => $user->id,
            'content' => '<p>Konten kegiatan bimtek mutu pendidikan.</p>',
            'excerpt' => 'Ringkasan kegiatan bimtek',
            'status' => 'published',
            'published_at' => '2025-05-10 10:00:00',
        ]);

        $response = $this->get('/berita');
        $response->assertStatus(200);
        $response->assertSee('Kegiatan Bimtek BPMP Sultra 2025');

        $detailResponse = $this->get('/berita/'.$post->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Kegiatan Bimtek BPMP Sultra 2025');
    }
}
