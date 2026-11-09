<?php

namespace Tests\Feature;

use App\Models\StandarPelayanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StandarPelayananFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_standar_pelayanan_index(): void
    {
        StandarPelayanan::create([
            'title' => 'SOP Layanan Informasi',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Pendidikan',
            'order_position' => 1,
            'is_active' => true,
            'file_path' => 'http://localhost/storage/test.pdf',
            'file_size' => '1.5 MB',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.standar-pelayanan.index'));

        $response->assertStatus(200);
        $response->assertSee('SOP Layanan Informasi');
        $response->assertSee('Pendidikan');
        $response->assertSee('Lihat Section');
    }

    public function test_admin_can_upload_pdf_or_word_file(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('sop-kepegawaian.docx', 500, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($this->admin)->post(route('admin.standar-pelayanan.store'), [
            'title' => 'Standar Layanan Kepegawaian',
            'category' => 'Kepegawaian',
            'source_type' => 'file',
            'file_dokumen' => $file,
            'is_active' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('standar_pelayanans', [
            'title' => 'Standar Layanan Kepegawaian',
            'category' => 'Kepegawaian',
            'source_type' => 'file',
            'file_extension' => 'docx',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_store_google_drive_link(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.standar-pelayanan.store'), [
            'title' => 'Pedoman Mutu di Google Drive',
            'category' => 'Umum',
            'source_type' => 'drive_link',
            'drive_url' => 'https://drive.google.com/file/d/1234567890/view',
            'is_active' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('standar_pelayanans', [
            'title' => 'Pedoman Mutu di Google Drive',
            'source_type' => 'drive_link',
            'file_extension' => 'link',
            'file_path' => 'https://drive.google.com/file/d/1234567890/view',
            'file_size' => 'Google Drive',
        ]);
    }

    public function test_admin_can_update_existing_document(): void
    {
        $doc = StandarPelayanan::create([
            'title' => 'Judul Lama',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Umum',
            'order_position' => 1,
            'is_active' => true,
            'file_path' => 'http://localhost/storage/old.pdf',
            'file_size' => '1.0 MB',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.standar-pelayanan.update', $doc), [
            'title' => 'Judul Baru Diperbarui',
            'category' => 'Pendidikan',
            'source_type' => 'drive_link',
            'drive_url' => 'https://drive.google.com/file/d/updated-link/view',
            'is_active' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('standar_pelayanans', [
            'id' => $doc->id,
            'title' => 'Judul Baru Diperbarui',
            'category' => 'Pendidikan',
            'source_type' => 'drive_link',
            'file_path' => 'https://drive.google.com/file/d/updated-link/view',
        ]);
    }

    public function test_admin_can_reorder_documents_via_ajax(): void
    {
        $doc1 = StandarPelayanan::create([
            'title' => 'Dokumen Pertama',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Umum',
            'order_position' => 1,
            'is_active' => true,
            'file_path' => 'http://localhost/test1.pdf',
            'file_size' => '1 MB',
            'uploaded_at' => now(),
        ]);

        $doc2 = StandarPelayanan::create([
            'title' => 'Dokumen Kedua',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Umum',
            'order_position' => 2,
            'is_active' => true,
            'file_path' => 'http://localhost/test2.pdf',
            'file_size' => '1 MB',
            'uploaded_at' => now(),
        ]);

        // Reorder: swap positions
        $response = $this->actingAs($this->admin)->postJson(route('admin.standar-pelayanan.reorder'), [
            'ids' => [$doc2->id, $doc1->id],
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);

        $this->assertEquals(1, $doc2->fresh()->order_position);
        $this->assertEquals(2, $doc1->fresh()->order_position);
    }

    public function test_admin_can_toggle_publication_status(): void
    {
        $doc = StandarPelayanan::create([
            'title' => 'Dokumen Toggle',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Umum',
            'order_position' => 1,
            'is_active' => true,
            'file_path' => 'http://localhost/test.pdf',
            'file_size' => '1 MB',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->patchJson(route('admin.standar-pelayanan.toggle-status', $doc));

        $response->assertOk();
        $response->assertJson(['success' => true, 'is_active' => false]);
        $this->assertFalse($doc->fresh()->is_active);
    }

    public function test_public_page_displays_active_documents_with_anchor_id(): void
    {
        $activeDoc = StandarPelayanan::create([
            'title' => 'Dokumen Standar Aktif Publik',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Pendidikan',
            'order_position' => 1,
            'is_active' => true,
            'file_path' => 'http://localhost/test-active.pdf',
            'file_size' => '2.1 MB',
            'uploaded_at' => now(),
        ]);

        $inactiveDoc = StandarPelayanan::create([
            'title' => 'Dokumen Rahasia Nonaktif',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'category' => 'Umum',
            'order_position' => 2,
            'is_active' => false,
            'file_path' => 'http://localhost/test-inactive.pdf',
            'file_size' => '1.0 MB',
            'uploaded_at' => now(),
        ]);

        $response = $this->get('/standar-pelayanan');

        $response->assertStatus(200);
        $response->assertSee('Dokumen Standar Aktif Publik');
        $response->assertSee('id="document-'.$activeDoc->id.'"', false);
        $response->assertDontSee('Dokumen Rahasia Nonaktif');
    }
}
