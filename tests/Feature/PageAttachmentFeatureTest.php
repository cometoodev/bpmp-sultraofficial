<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\PageAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageAttachmentFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Page $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->page = Page::create([
            'title' => 'Rencana Strategis (RENSTRA)',
            'slug' => 'renstra-bpmp',
            'content' => '<p>Deskripsi halaman RENSTRA BPMP Sulawesi Tenggara.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function test_pages_index_shows_attachment_action_button(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pages.index'));

        $response->assertStatus(200);
        $response->assertSee(route('admin.pages.attachments', $this->page));
    }

    public function test_admin_can_view_page_attachments_index(): void
    {
        PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Dokumen RENSTRA 2024-2029',
            'source_type' => 'file',
            'file_path' => 'page-attachments/test.pdf',
            'file_name' => 'renstra.pdf',
            'file_extension' => 'pdf',
            'file_size' => '2.4 MB',
            'category' => 'Perencanaan',
            'order_position' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.pages.attachments', $this->page));

        $response->assertStatus(200);
        $response->assertSee('Dokumen RENSTRA 2024-2029');
        $response->assertSee('Perencanaan');
    }

    public function test_admin_can_upload_local_attachment_file(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('dokumen-dipa-2026.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($this->admin)->post(route('admin.pages.attachments.store', $this->page), [
            'title' => 'DIPA Petikan BPMP Sultra 2026',
            'category' => 'Keuangan',
            'source_type' => 'file',
            'file' => $file,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.pages.attachments', $this->page));

        $this->assertDatabaseHas('page_attachments', [
            'page_id' => $this->page->id,
            'title' => 'DIPA Petikan BPMP Sultra 2026',
            'category' => 'Keuangan',
            'source_type' => 'file',
            'file_extension' => 'pdf',
            'is_active' => true,
            'order_position' => 1,
        ]);
    }

    public function test_admin_can_store_google_drive_attachment(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.pages.attachments.store', $this->page), [
            'title' => 'Folder Drive Lampiran Renstra Lengkap',
            'category' => 'Cloud Repository',
            'source_type' => 'drive',
            'drive_url' => 'https://drive.google.com/drive/folders/1234567890abcdef',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.pages.attachments', $this->page));

        $this->assertDatabaseHas('page_attachments', [
            'page_id' => $this->page->id,
            'title' => 'Folder Drive Lampiran Renstra Lengkap',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/drive/folders/1234567890abcdef',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_attachment(): void
    {
        $attachment = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Draft Laporan',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/old',
            'category' => 'Laporan',
            'order_position' => 1,
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.pages.attachments.update', [$this->page, $attachment]), [
            'title' => 'Laporan Akuntabilitas Kinerja (LAKIN) Final',
            'category' => 'LAKIN',
            'source_type' => 'drive',
            'drive_url' => 'https://drive.google.com/new-final',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.pages.attachments', $this->page));

        $this->assertDatabaseHas('page_attachments', [
            'id' => $attachment->id,
            'title' => 'Laporan Akuntabilitas Kinerja (LAKIN) Final',
            'category' => 'LAKIN',
            'file_path' => 'https://drive.google.com/new-final',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_reorder_attachments_via_ajax(): void
    {
        $doc1 = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Dokumen Satu',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/1',
            'order_position' => 1,
        ]);

        $doc2 = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Dokumen Dua',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/2',
            'order_position' => 2,
        ]);

        $response = $this->actingAs($this->admin)->postJson(route('admin.pages.attachments.reorder', $this->page), [
            'order' => [$doc2->id, $doc1->id],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $this->assertEquals(1, $doc2->fresh()->order_position);
        $this->assertEquals(2, $doc1->fresh()->order_position);
    }

    public function test_admin_can_toggle_attachment_publication_status(): void
    {
        $attachment = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Dokumen Uji Coba',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/test',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->patchJson(route('admin.pages.attachments.toggle-status', [$this->page, $attachment]));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success', 'is_active' => false]);
        $this->assertFalse($attachment->fresh()->is_active);
    }

    public function test_public_page_displays_active_attachments_with_anchor_id(): void
    {
        $activeDoc = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Buku Renstra Publik',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/renstra-public',
            'is_active' => true,
            'order_position' => 1,
        ]);

        $inactiveDoc = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Draft Dokumen Rahasia',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/draft',
            'is_active' => false,
            'order_position' => 2,
        ]);

        $response = $this->get('/'.$this->page->slug);

        $response->assertStatus(200);
        $response->assertSee('Dokumen &amp; Lampiran Terkait', false);
        $response->assertSee('Buku Renstra Publik');
        $response->assertSee('document-'.$activeDoc->id);
        $response->assertDontSee('Draft Dokumen Rahasia');
    }

    public function test_public_download_increments_counter_and_redirects_drive(): void
    {
        $attachment = PageAttachment::create([
            'page_id' => $this->page->id,
            'title' => 'Google Drive File',
            'source_type' => 'drive',
            'file_path' => 'https://drive.google.com/file/d/abcdef123',
            'is_active' => true,
            'download_count' => 5,
        ]);

        $response = $this->get(route('pages.attachments.download', $attachment));

        $response->assertRedirect('https://drive.google.com/file/d/abcdef123');
        $this->assertEquals(6, $attachment->fresh()->download_count);
    }
}
