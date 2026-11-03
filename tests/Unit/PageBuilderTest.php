<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\PageController;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use Tests\TestCase;

class PageBuilderTest extends TestCase
{
    public function test_page_design_method_accessor(): void
    {
        $page = new Page;
        $page->editor_mode = 'visual';
        $this->assertEquals('builder', $page->design_method);
        $this->assertTrue($page->isBuilder());

        $page->editor_mode = 'html';
        $this->assertEquals('html', $page->design_method);
    }

    public function test_compile_single_block_cards_renders_glassmorphism(): void
    {
        $controller = new PageController;
        $block = [
            'type' => 'cards',
            'settings' => ['bg' => 'transparent', 'padding' => 'none'],
            'content' => [
                'heading' => 'Daftar Layanan',
                'columns' => 3,
                'items' => [
                    [
                        'title' => 'Layanan Mutu',
                        'description' => 'Fasilitasi penjaminan mutu pendidikan.',
                        'image' => 'https://example.com/layanan.jpg',
                        'button_text' => 'Detail',
                        'button_url' => '/layanan-mutu',
                    ],
                ],
            ],
        ];

        $html = $controller->compileSingleBlock($block);

        $this->assertStringContainsString('grid grid-cols-1 md:grid-cols-3 gap-6 my-8', $html);
        $this->assertStringContainsString('bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm hover:shadow-lg rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1', $html);
        $this->assertStringContainsString('Layanan Mutu', $html);
    }

    public function test_compile_single_block_image_text_renders_glassmorphism(): void
    {
        $controller = new PageController;
        $block = [
            'type' => 'image_text',
            'settings' => ['bg' => 'transparent', 'padding' => 'none', 'image_position' => 'left'],
            'content' => [
                'title' => 'Profil Singkat',
                'description' => 'Penjelasan mengenai institusi BPMP Sultra.',
                'image' => 'https://example.com/profil.jpg',
                'button_text' => 'Baca Lengkap',
                'button_url' => '/profil',
            ],
        ];

        $html = $controller->compileSingleBlock($block);

        $this->assertStringContainsString('flex flex-col md:flex-row gap-8 bg-white/70 backdrop-blur-lg p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 my-8 items-center', $html);
        $this->assertStringContainsString('w-full md:w-1/3 shrink-0 rounded-2xl overflow-hidden border-4 border-white shadow-md', $html);
        $this->assertStringContainsString('Profil Singkat', $html);
    }

    public function test_compile_builder_data_combines_blocks(): void
    {
        $controller = new PageController;
        $blocks = [
            [
                'type' => 'text',
                'settings' => ['bg' => 'transparent', 'padding' => 'none'],
                'content' => ['html' => '<div class="prose">Halo Dunia</div>'],
            ],
        ];

        $html = $controller->compileBuilderData(json_encode($blocks));
        $this->assertStringContainsString('Halo Dunia', $html);
    }

    public function test_compile_single_block_gallery_slider(): void
    {
        $controller = new PageController;
        $block = [
            'type' => 'gallery_slider',
            'settings' => ['bg' => 'transparent', 'padding' => 'none'],
            'content' => [
                'heading' => 'Galeri Pegawai BPMP',
                'subheading' => 'Daftar ASN Berprestasi',
                'items' => [
                    [
                        'name' => 'Ahmad, M.Pd.',
                        'role' => 'Widyaprada',
                        'image' => 'https://example.com/ahmad.jpg',
                    ],
                ],
            ],
        ];

        $html = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('animate-marquee', $html);
        $this->assertStringContainsString('Galeri Pegawai BPMP', $html);
        $this->assertStringContainsString('Ahmad, M.Pd.', $html);
    }

    public function test_compile_single_block_profile_table(): void
    {
        $controller = new PageController;
        $block = [
            'type' => 'profile_table',
            'settings' => ['bg' => 'transparent', 'padding' => 'none'],
            'content' => [
                'name' => 'Dr. Pejabat, M.Pd.',
                'role' => 'Kepala Balai',
                'details' => [
                    ['label' => 'NIP', 'value' => '197501012000031001'],
                ],
            ],
        ];

        $html = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('Dr. Pejabat, M.Pd.', $html);
        $this->assertStringContainsString('197501012000031001', $html);
        $this->assertStringContainsString('Kepala Balai', $html);
    }

    public function test_compile_single_block_html_custom_renders_raw_html(): void
    {
        $controller = new PageController;
        $block = [
            'type' => 'html_custom',
            'settings' => ['bg' => 'transparent', 'padding' => 'none'],
            'content' => [
                'html' => '<div class="custom-tailwind-container"><h1 class="text-3xl font-black">Konten Sinkronisasi</h1></div>',
            ],
            'html_output' => '<div class="custom-tailwind-container"><h1 class="text-3xl font-black">Konten Sinkronisasi</h1></div>',
        ];

        $html = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('custom-tailwind-container', $html);
        $this->assertStringContainsString('Konten Sinkronisasi', $html);
        $this->assertEquals('<div class="custom-tailwind-container"><h1 class="text-3xl font-black">Konten Sinkronisasi</h1></div>', trim($html));
    }

    public function test_compile_single_block_html_custom_with_string_content_preserves_tailwind_classes_and_tags(): void
    {
        $controller = new PageController;
        $rawHtml = '<div class="grid grid-cols-1 md:grid-cols-3 gap-6"><div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100"><h3 class="text-xl font-bold text-slate-800">Program Prioritas</h3><p class="text-slate-600">Deskripsi program prioritas.</p></div></div>';
        $block = [
            'type' => 'html_custom',
            'settings' => ['bg' => 'transparent', 'padding' => 'none'],
            'content' => $rawHtml,
            'html_output' => $rawHtml,
        ];

        $html = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('grid grid-cols-1 md:grid-cols-3 gap-6', $html);
        $this->assertStringContainsString('rounded-3xl p-6 shadow-xl border border-slate-100', $html);
        $this->assertStringContainsString('Program Prioritas', $html);
        $this->assertEquals($rawHtml, trim($html));
    }

    public function test_compile_single_block_handles_stdclass_objects_without_error(): void
    {
        $controller = new PageController;
        $json = json_encode([
            'type' => 'cards',
            'settings' => ['bg' => 'white', 'padding' => 'medium'],
            'content' => [
                'heading' => 'Kartu Layanan',
                'columns' => 2,
                'items' => [
                    ['title' => 'Judul 1', 'description' => 'Deskripsi 1'],
                ],
            ],
        ]);

        // Decode TANPA true menghasilkan stdClass dengan nested stdClass
        $stdClassBlock = json_decode($json);

        $html = $controller->compileSingleBlock($stdClassBlock);
        $this->assertStringContainsString('Kartu Layanan', $html);
        $this->assertStringContainsString('Judul 1', $html);
    }

    public function test_compile_skm_utama_template_renders_lightbox_modal_and_quarterly_cards(): void
    {
        $controller = new PageController;
        $skmHtml = '<div x-data="{ showModal: false, modalImg: \'\', modalTitle: \'\' }" class="w-full max-w-6xl mx-auto py-12"><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8"><div class="bg-white/70 backdrop-blur-xl rounded-[2rem] border border-slate-100 shadow-sm"><h3 class="text-xl font-bold">Triwulan I</h3></div></div><div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4"><div x-show="showModal" class="fixed inset-0 bg-slate-900/70"></div></div></div>';

        $block = [
            'type' => 'html_custom',
            'settings' => ['bg' => 'transparent', 'padding' => 'none', 'align' => '', 'wrapper_class' => ''],
            'content' => ['html' => $skmHtml],
        ];

        $html = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('x-data="{ showModal: false, modalImg: \'\', modalTitle: \'\' }"', $html);
        $this->assertStringContainsString('Triwulan I', $html);
        $this->assertStringContainsString('z-[999]', $html);
    }

    public function test_compile_skm_detail_template_renders_document_tabs_and_pdf_iframes(): void
    {
        $controller = new PageController;
        $skmDetailHtml = '<div x-data="{ activeDocTab: \'skm\' }" class="w-full max-w-6xl mx-auto py-8"><button @click="activeDocTab = \'skm\'">Dokumen Laporan SKM</button><button @click="activeDocTab = \'tindak-lanjut\'">Tindak Lanjut Hasil SKM</button><div x-show="activeDocTab === \'skm\'"><iframe src="https://drive.google.com/file/d/CONTOH/preview"></iframe></div></div>';

        $block = [
            'type' => 'html_custom',
            'settings' => ['bg' => 'transparent', 'padding' => 'none', 'align' => '', 'wrapper_class' => ''],
            'content' => ['html' => $skmDetailHtml],
        ];

        $html = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('x-data="{ activeDocTab: \'skm\' }"', $html);
        $this->assertStringContainsString('Dokumen Laporan SKM', $html);
        $this->assertStringContainsString('Tindak Lanjut Hasil SKM', $html);
        $this->assertStringContainsString('iframe', $html);
    }

    public function test_clean_and_normalize_removes_markdown_wrapper_from_iframe_src(): void
    {
        $controller = new PageController;
        $htmlWithMarkdownIframe = '<iframe src="[https://drive.google.com/file/d/XYZ/preview](https://drive.google.com/file/d/XYZ/preview)"></iframe>';

        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('cleanAndNormalizeHtml');
        $method->setAccessible(true);

        $cleaned = $method->invoke($controller, $htmlWithMarkdownIframe);
        $this->assertStringContainsString('src="https://drive.google.com/file/d/XYZ/preview"', $cleaned);
        $this->assertStringNotContainsString('[https://', $cleaned);
    }

    public function test_page_url_accessor_with_nested_slug(): void
    {
        $page = new Page;
        $page->slug = 'skm/tw1';

        $this->assertEquals(url('skm/tw1'), $page->url);
    }

    public function test_page_request_rules_permit_nested_slugs_with_slashes(): void
    {
        $rules = (new PageRequest)->rules();
        $slugRules = $rules['slug'];

        $this->assertContains('regex:/^[a-zA-Z0-9\-_\/]+$/', $slugRules);
    }

    public function test_compile_profil_mutu_template_renders_split_layout_and_district_grid(): void
    {
        $controller = new PageController;
        $html = '<div class="w-full max-w-7xl mx-auto space-y-12 py-8"><h2 class="text-3xl font-extrabold text-slate-800">Mewujudkan Layanan Pendidikan yang Adaptif &amp; Inklusif</h2><div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"><a href="/profil-mutu/provinsi">Provinsi Sulawesi Tenggara</a></div></div>';

        $block = [
            'type' => 'html_custom',
            'settings' => ['bg' => 'transparent', 'padding' => 'none', 'align' => '', 'wrapper_class' => ''],
            'content' => ['html' => $html],
        ];

        $compiled = $controller->compileSingleBlock($block);
        $this->assertStringContainsString('max-w-7xl', $compiled);
        $this->assertStringContainsString('Mewujudkan Layanan Pendidikan yang Adaptif &amp; Inklusif', $compiled);
        $this->assertStringContainsString('xl:grid-cols-5', $compiled);
        $this->assertStringContainsString('Provinsi Sulawesi Tenggara', $compiled);
    }
}
