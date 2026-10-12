<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = public_path('Posts-Export-2026-October-11-0524.csv');
        if (! file_exists($csvPath)) {
            if ($this->command) {
                $this->command->error("File CSV tidak ditemukan di: {$csvPath}");
            }

            return;
        }

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);
        if (! $header) {
            if ($this->command) {
                $this->command->error('Header CSV tidak dapat dibaca.');
            }
            fclose($handle);

            return;
        }

        // Hapus BOM UTF-8 bila ada
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        $defaultAdmin = User::first() ?? User::create([
            'name' => 'Administrator BPMP',
            'email' => 'admin@bpmp.kemdikbud.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                $skipped++;

                continue;
            }

            $data = array_combine($header, $row);
            $rawDate = trim($data['Date'] ?? '');
            $year = substr($rawDate, 0, 4);

            // Filter hanya berita dari tahun 2025 sampai data terbaru
            if ($year < '2025') {
                $skipped++;

                continue;
            }

            $title = trim($data['Title'] ?? '');
            if (empty($title)) {
                $skipped++;

                continue;
            }

            // Slug unik
            $rawSlug = trim($data['Slug'] ?? '');
            $slug = ! empty($rawSlug) ? Str::slug($rawSlug) : Str::slug($title);

            // Tanggal terbit
            try {
                $publishedAt = Carbon::parse($rawDate);
            } catch (\Exception $e) {
                $publishedAt = now();
            }

            // Kategori
            $rawCategories = trim($data['Categories'] ?? '');
            $categoryId = null;
            if (! empty($rawCategories)) {
                $catParts = explode('|', $rawCategories);
                $firstCatName = trim($catParts[0]);
                if (! empty($firstCatName)) {
                    $category = Category::firstOrCreate(
                        ['slug' => Str::slug($firstCatName)],
                        [
                            'name' => $firstCatName,
                            'description' => "Kategori {$firstCatName}",
                            'is_active' => true,
                        ]
                    );
                    $categoryId = $category->id;
                }
            }

            // Penulis (Author)
            $authorEmail = trim($data['Author Email'] ?? '');
            $authorId = $defaultAdmin->id;
            if (! empty($authorEmail)) {
                $authorName = trim(($data['Author First Name'] ?? '').' '.($data['Author Last Name'] ?? ''));
                if (empty($authorName)) {
                    $authorName = trim($data['Author Username'] ?? 'Penulis BPMP');
                }
                $author = User::firstOrCreate(
                    ['email' => $authorEmail],
                    [
                        'name' => $authorName ?: 'Penulis BPMP',
                        'password' => Hash::make('password123'),
                        'role' => 'editor',
                    ]
                );
                $authorId = $author->id;
            }

            // Ekstraksi Thumbnail
            $thumbnail = null;
            $imgFeatured = trim($data['Image Featured'] ?? '');
            $imgUrl = trim($data['Image URL'] ?? '');
            if (! empty($imgFeatured)) {
                $thumbnail = $imgFeatured;
            } elseif (! empty($imgUrl)) {
                $urls = explode('|', $imgUrl);
                $thumbnail = trim($urls[0]);
            }

            // Konten & Ringkasan
            $content = $data['Content'] ?? '';
            $rawExcerpt = trim($data['Excerpt'] ?? '');
            $excerpt = ! empty($rawExcerpt) ? $rawExcerpt : Str::limit(strip_tags($content), 200);

            // Status publikasi
            $status = (strtolower(trim($data['Status'] ?? '')) === 'publish') ? 'published' : 'draft';

            // Simpan / Perbarui Post
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'category_id' => $categoryId,
                    'author_id' => $authorId,
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'thumbnail' => $thumbnail,
                    'status' => $status,
                    'published_at' => $publishedAt,
                    'created_at' => $publishedAt,
                    'updated_at' => ! empty($data['Post Modified Date']) ? Carbon::parse($data['Post Modified Date']) : $publishedAt,
                ]
            );

            if ($post->wasRecentlyCreated) {
                $imported++;
            } else {
                $updated++;
            }
        }

        fclose($handle);

        if ($this->command) {
            $this->command->info("Impor Berita Selesai: {$imported} berita baru ditambahkan, {$updated} diperbarui, {$skipped} dilewati (tahun < 2025).");
        }
    }
}
