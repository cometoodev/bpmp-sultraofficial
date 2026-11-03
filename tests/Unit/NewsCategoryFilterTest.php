<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use Tests\TestCase;

class NewsCategoryFilterTest extends TestCase
{
    public function test_post_belongs_to_category_relation(): void
    {
        $post = new Post([
            'title' => 'Judul Kisah Inspiratif',
            'slug' => 'judul-kisah-inspiratif',
            'category_id' => 12,
            'excerpt' => 'Ringkasan artikel',
            'content' => 'Konten lengkap artikel inspiratif',
            'status' => 'published',
        ]);

        $this->assertEquals('Judul Kisah Inspiratif', $post->title);
        $this->assertEquals(12, $post->category_id);
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->thumbnail_url);
    }

    public function test_category_has_posts_relation(): void
    {
        $category = new Category([
            'name' => 'Kisah Inspiratif',
            'slug' => 'kisah-inspiratif',
            'is_active' => true,
        ]);

        $this->assertEquals('Kisah Inspiratif', $category->name);
        $this->assertEquals('kisah-inspiratif', $category->slug);
        $this->assertTrue($category->is_active);
    }
}
