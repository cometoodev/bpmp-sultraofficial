<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Media;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Page::query()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'semua') {
            $query->where('status', $request->input('status'));
        }

        $pages = $query->paginate(10)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $validated = $this->syncStateData($validated, $request);

        $page = Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$page->title}' berhasil dibuat.");
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        if ($validated['status'] === 'published' && empty($validated['published_at']) && empty($page->published_at)) {
            $validated['published_at'] = now();
        }

        $validated = $this->syncStateData($validated, $request);

        $page->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Halaman '{$page->title}' berhasil diperbarui.",
                'page' => $page,
            ]);
        }

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$page->title}' berhasil diperbarui.");
    }

    public function destroy(Page $page): RedirectResponse
    {
        $title = $page->title;

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$title}' berhasil dihapus.");
    }

    public function preview(Page $page): View
    {
        return view('pages.show', [
            'page' => $page,
            'isPreview' => true,
        ]);
    }

    public function builder(Page $page): View
    {
        $builderData = json_decode($page->builder_data ?? '[]', true);
        if (empty($builderData)) {
            $rawHtml = $page->html_content ?: $page->content;
            if (! empty(trim($rawHtml ?? ''))) {
                $cleanHtml = $this->cleanAndNormalizeHtml($rawHtml);

                $builderData = [
                    [
                        'id' => uniqid('block_'),
                        'type' => 'html_custom',
                        'content' => $cleanHtml,
                        'settings' => [
                            'bg' => 'transparent',
                            'padding' => 'none',
                            'align' => 'left',
                            'wrapper_class' => '',
                        ],
                        'html_output' => $cleanHtml,
                        'html_content' => $cleanHtml,
                    ],
                ];
                $page->builder_data = json_encode($builderData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }

        return view('admin.pages.builder', [
            'page' => $page,
        ]);
    }

    public function saveBuilder(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'builder_data' => 'nullable|string',
            'editor_mode' => 'required|string|in:visual,html',
        ]);

        $rawBlocks = json_decode($validated['builder_data'] ?? '[]', true) ?: [];

        $blocksWithHtml = [];
        $fullHtml = '';
        foreach ($rawBlocks as $block) {
            if (($block['type'] ?? '') === 'html_custom' || ($block['type'] ?? '') === 'text' || ($block['type'] ?? '') === 'html') {
                if (isset($block['content']) && is_string($block['content'])) {
                    $block['content'] = $this->cleanAndNormalizeHtml($block['content']);
                } elseif (isset($block['content']['html']) && is_string($block['content']['html'])) {
                    $block['content']['html'] = $this->cleanAndNormalizeHtml($block['content']['html']);
                }
            }

            $blockHtml = $this->compileSingleBlock($block);
            $block['html_content'] = $blockHtml;
            $block['html_output'] = $blockHtml;
            $blocksWithHtml[] = $block;
            $fullHtml .= $blockHtml."\n";
        }

        $page->update([
            'builder_data' => json_encode($blocksWithHtml, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'editor_mode' => $validated['editor_mode'],
            'content' => $fullHtml,
            'html_content' => $fullHtml,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Sanitasi dan normalisasi HTML tanpa membuang tag HTML maupun atribut styling Tailwind.
     */
    private function cleanAndNormalizeHtml(string $html): string
    {
        if (empty(trim($html))) {
            return '';
        }

        // Jika dokumen merupakan HTML lengkap (memuat <!DOCTYPE atau <html> atau <body>),
        // ekstrak konten body dan style agar pas di dalam kontainer tanpa memotong parser DOM
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $bodyMatches)) {
            $styles = '';
            if (preg_match_all('/<style[^>]*>.*?<\/style>/is', $html, $styleMatches)) {
                $styles = implode("\n", $styleMatches[0]);
            }

            $bodyClass = '';
            if (preg_match('/<body[^>]*class=["\']([^"\']*)["\']/i', $html, $classMatches)) {
                $bodyClass = $classMatches[1];
            }

            $bodyInner = trim($bodyMatches[1]);
            if (! empty($bodyClass)) {
                $html = $styles."\n<div class=\"{$bodyClass}\">\n{$bodyInner}\n</div>";
            } else {
                $html = $styles."\n".$bodyInner;
            }
        }

        // Bersihkan escape newline ganda tanpa merusak tag HTML atau spasi atribut
        $html = str_replace(['\\r\\n', '\\r', '\\n', '\r\n', '\r', '\n'], "\n", $html);
        $html = str_replace("\r\n", "\n", $html);
        $html = str_replace("\r", '', $html);

        // Bersihkan URL iframe atau link yang terbawa format markdown [url](url)
        $html = preg_replace('/src=["\']\s*\[([^\]]+)\]\([^)]+\)\s*["\']/i', 'src="$1"', $html);
        $html = preg_replace('/href=["\']\s*\[([^\]]+)\]\([^)]+\)\s*["\']/i', 'href="$1"', $html);

        return trim($html);
    }

    /**
     * Sinkronisasi data state dua arah antara mode HTML dan Visual Builder.
     */
    private function syncStateData(array $validated, Request $request): array
    {
        $designMethod = $request->input('design_method');
        if (! $designMethod) {
            $designMethod = ($validated['editor_mode'] ?? 'html') === 'visual' ? 'builder' : 'html';
        }

        if ($designMethod === 'html') {
            $htmlContent = $request->input('html_content') ?? $validated['html_content'] ?? $validated['content'] ?? '';

            // Pertahankan seluruh tag HTML & class Tailwind utuh
            $cleanHtml = $this->cleanAndNormalizeHtml($htmlContent);

            $validated['content'] = $cleanHtml;
            $validated['html_content'] = $cleanHtml;
            $validated['editor_mode'] = 'html';

            $builderData = [
                [
                    'id' => uniqid('block_'),
                    'type' => 'html_custom',
                    'content' => $cleanHtml, // Gunakan HTML yang sudah dinormalisasi tanpa strip_tags
                    'settings' => [
                        'bg' => 'transparent',
                        'padding' => 'none',
                        'align' => 'left',
                        'wrapper_class' => '',
                    ],
                    'html_output' => $cleanHtml,
                    'html_content' => $cleanHtml,
                ],
            ];

            // Gunakan flag JSON agar tag HTML tidak di-escape secara agresif
            $validated['builder_data'] = json_encode($builderData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } elseif ($designMethod === 'builder' || $designMethod === 'visual') {
            $validated['editor_mode'] = 'visual';
            $builderDataJson = $validated['builder_data'] ?? '[]';
            $rawBlocks = json_decode($builderDataJson, true) ?: [];

            if (! empty($rawBlocks)) {
                $blocksWithHtml = [];
                $compiledHtml = '';
                foreach ($rawBlocks as $block) {
                    if (($block['type'] ?? '') === 'html_custom' || ($block['type'] ?? '') === 'text' || ($block['type'] ?? '') === 'html') {
                        if (isset($block['content']) && is_string($block['content'])) {
                            $block['content'] = $this->cleanAndNormalizeHtml($block['content']);
                        } elseif (isset($block['content']['html']) && is_string($block['content']['html'])) {
                            $block['content']['html'] = $this->cleanAndNormalizeHtml($block['content']['html']);
                        }
                    }

                    $blockHtml = $this->compileSingleBlock($block);
                    $block['html_content'] = $blockHtml;
                    $block['html_output'] = $blockHtml;
                    $blocksWithHtml[] = $block;
                    $compiledHtml .= $blockHtml."\n";
                }

                $validated['builder_data'] = json_encode($blocksWithHtml, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $validated['content'] = $compiledHtml;
                $validated['html_content'] = $compiledHtml;
            } elseif (! empty($validated['content']) || ! empty($validated['html_content'])) {
                $html = $validated['html_content'] ?? $validated['content'] ?? '';
                $cleanHtml = $this->cleanAndNormalizeHtml($html);
                $validated['content'] = $cleanHtml;
                $validated['html_content'] = $cleanHtml;
            }
        }

        return $validated;
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $safeName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)).'-'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('media', $safeName, 'public');

        Media::create([
            'filename' => $originalName,
            'path' => $path,
            'mime_type' => $mimeType,
            'size' => $size,
            'uploaded_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    private function compileText(string $text, array $settings, string $defaultClasses = '', string $defaultTag = 'p'): string
    {
        if (empty(trim($text))) {
            return '';
        }
        $tag = ! empty($settings['tag']) ? $settings['tag'] : $defaultTag;

        $classes = [$defaultClasses, '!break-words', '!break-all'];
        if (! empty($settings['size'])) {
            $classes[] = $settings['size'];
        }
        if (! empty($settings['weight'])) {
            $classes[] = $settings['weight'];
        }
        if (! empty($settings['align'])) {
            $classes[] = $settings['align'];
        }
        if (! empty($settings['line_height'])) {
            $classes[] = $settings['line_height'];
        }
        if (! empty($settings['letter_spacing'])) {
            $classes[] = $settings['letter_spacing'];
        }
        if (! empty($settings['italic'])) {
            $classes[] = 'italic';
        }
        if (! empty($settings['underline'])) {
            $classes[] = 'underline';
        }
        if (! empty($settings['mt'])) {
            $classes[] = $settings['mt'];
        }
        if (! empty($settings['mb'])) {
            $classes[] = $settings['mb'];
        }

        $style = '';
        if (! empty($settings['color'])) {
            $style = " style=\"color: {$settings['color']}\"";
        }

        $classStr = trim(implode(' ', array_filter($classes)));

        $open = "<{$tag} class=\"{$classStr}\"{$style}>";
        $close = "</{$tag}>";

        if (! empty($settings['link'])) {
            $open .= '<a href="'.htmlspecialchars($settings['link']).'" class="hover:opacity-80 transition-opacity">';
            $close = '</a>'.$close;
        }

        return $open.$text.$close;
    }

    public function compileBuilderData(string $json): string
    {
        $data = json_decode($json, true);
        if (! is_array($data)) {
            return '';
        }

        $html = '';
        foreach ($data as $block) {
            $html .= $this->compileSingleBlock($block)."\n";
        }

        return $html;
    }

    public function compileSingleBlock(array|object $block): string
    {
        if (is_object($block)) {
            $block = json_decode(json_encode($block), true) ?: (array) $block;
        }

        $type = $block['type'] ?? '';
        $content = is_object($block['content'] ?? null) ? (array) $block['content'] : ($block['content'] ?? []);
        $settings = is_object($block['settings'] ?? null) ? (array) $block['settings'] : ($block['settings'] ?? []);

        // Compile settings into classes
        $classes = [];
        if (! empty($settings['bg'])) {
            $classes[] = $settings['bg'] === 'white' ? 'bg-white' : ($settings['bg'] === 'gray' ? 'bg-slate-50' : ($settings['bg'] === 'blue' ? 'bg-blue-50' : 'bg-transparent'));
        }
        if (isset($settings['padding'])) {
            $classes[] = $settings['padding'] === 'none' ? 'py-0' : ($settings['padding'] === 'small' ? 'py-8' : ($settings['padding'] === 'large' ? 'py-24' : 'py-16'));
        }
        if (! empty($settings['align'])) {
            $classes[] = 'text-'.$settings['align'];
        }

        $classStr = implode(' ', array_filter($classes));
        $wrapperStart = "<section class=\"{$classStr}\"><div class=\"container mx-auto px-4 max-w-5xl\">";
        $wrapperEnd = '</div></section>';

        switch ($type) {
            case 'glass_split':
                return view('components.builder.glass-split', ['block' => $block])->render();

            case 'glass_cards':
                return view('components.builder.glass-cards', ['block' => $block])->render();

            case 'hero':
                $title = $content['title'] ?? '';
                $titleSettings = $content['title_settings'] ?? [];
                $desc = $content['description'] ?? '';
                $descSettings = $content['description_settings'] ?? [];
                $btnTxt = htmlspecialchars($content['button_text'] ?? '');
                $btnUrl = htmlspecialchars($content['button_url'] ?? '#');
                $bgImg = $content['bg_image'] ?? '';

                $titleColor = $bgImg ? 'text-white' : 'text-slate-900';
                $descColor = $bgImg ? 'text-slate-200' : 'text-slate-600';

                $compiledTitle = $this->compileText(htmlspecialchars($title), $titleSettings, "text-4xl md:text-5xl lg:text-6xl font-extrabold {$titleColor} leading-tight", 'h1');
                $compiledDesc = $this->compileText(htmlspecialchars($desc), $descSettings, "text-lg {$descColor}");

                $btnHtml = $btnTxt ? "<div class=\"pt-4\"><a href=\"{$btnUrl}\" class=\"inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5\">{$btnTxt}</a></div>" : '';

                if ($bgImg) {
                    $safeBg = htmlspecialchars($bgImg);
                    $heroInner = "<div class=\"relative rounded-3xl overflow-hidden py-16 md:py-24 px-6 md:px-12 my-6 text-center shadow-xl\">
                        <div class=\"absolute inset-0 bg-cover bg-center\" style=\"background-image: url('{$safeBg}');\"></div>
                        <div class=\"absolute inset-0 bg-gradient-to-r from-blue-900/80 via-slate-900/70 to-indigo-900/80 backdrop-blur-[2px]\"></div>
                        <div class=\"relative z-10 max-w-4xl mx-auto space-y-6\">
                            {$compiledTitle}
                            {$compiledDesc}
                            {$btnHtml}
                        </div>
                    </div>";
                } else {
                    $heroInner = "<div class=\"max-w-4xl mx-auto text-center space-y-6\">
                            {$compiledTitle}
                            {$compiledDesc}
                            {$btnHtml}
                        </div>";
                }

                if (! empty($settings['wrapper_class'])) {
                    $heroInner = "<div class=\"{$settings['wrapper_class']}\">{$heroInner}</div>";
                }

                return $wrapperStart."\n{$heroInner}\n".$wrapperEnd;

            case 'html':
            case 'text':
            case 'html_custom':
                $textContent = is_string($content) ? $content : ($content['html'] ?? '');
                if (empty($textContent) && ! empty($block['html_output'])) {
                    $textContent = $block['html_output'];
                }
                // Pastikan teks bebas dari literal \r\n maupun escaped sequence
                $textContent = str_replace(['\\r\\n', '\\r', '\\n', '\r\n', '\r', '\n', "\r\n", "\r", "\n"], ' ', $textContent);
                $innerContent = $textContent;
                if (! empty($settings['wrapper_class'])) {
                    $innerContent = "<div class=\"{$settings['wrapper_class']}\">{$innerContent}</div>";
                }

                if (($settings['padding'] ?? '') === 'none' && (empty($settings['bg']) || $settings['bg'] === 'transparent') && empty($settings['align'])) {
                    return $innerContent;
                }

                return $wrapperStart."\n{$innerContent}\n".$wrapperEnd;

            case 'cards':
                $cols = $content['columns'] ?? 3;
                $gridClass = $cols == 2 ? 'grid-cols-1 md:grid-cols-2' : ($cols == 4 ? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4' : 'grid-cols-1 md:grid-cols-3');

                $compiledHeading = $this->compileText(htmlspecialchars($content['heading'] ?? ''), $content['heading_settings'] ?? [], 'text-3xl font-bold text-slate-900', 'h2');

                $headingHtml = $compiledHeading ? "<div class=\"text-center mb-8\">{$compiledHeading}</div>" : '';

                $cardsGrid = "{$headingHtml}\n<div class=\"grid {$gridClass} gap-6 my-8\">";

                foreach ($content['items'] ?? [] as $item) {
                    $compiledItemTitle = $this->compileText(htmlspecialchars($item['title'] ?? ''), $item['title_settings'] ?? [], 'text-xl font-bold text-slate-800 mb-2', 'h3');
                    $compiledItemDesc = $this->compileText(htmlspecialchars($item['description'] ?? ''), $item['description_settings'] ?? [], 'text-slate-600 mb-4 flex-grow leading-relaxed');

                    $imgHtml = ! empty($item['image']) ? '<div class="rounded-2xl overflow-hidden mb-4"><img src="'.htmlspecialchars($item['image']).'" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500"></div>' : '';
                    $btnItemHtml = ! empty($item['button_text']) ? '<div class="mt-auto pt-2"><a href="'.htmlspecialchars($item['button_url'] ?? '#').'" class="text-blue-600 font-bold hover:text-blue-700 inline-flex items-center gap-1 text-sm">'.htmlspecialchars($item['button_text']).' <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></div>' : '';

                    $cardsGrid .= "<div class=\"bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm hover:shadow-lg rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 flex flex-col\">
                        {$imgHtml}
                        <div class=\"flex-grow flex flex-col\">
                            {$compiledItemTitle}
                            {$compiledItemDesc}
                            {$btnItemHtml}
                        </div>
                    </div>";
                }

                $cardsGrid .= '</div>';

                if (! empty($settings['wrapper_class'])) {
                    $cardsGrid = "<div class=\"{$settings['wrapper_class']}\">{$cardsGrid}</div>";
                }

                return $wrapperStart."\n{$cardsGrid}\n".$wrapperEnd;

            case 'image_text':
                $imgPos = $settings['image_position'] ?? 'left';
                $rawTitle = $content['title'] ?? '';
                if (str_contains($rawTitle, '<')) {
                    $compiledTitle = $rawTitle;
                } else {
                    $compiledTitle = $this->compileText(htmlspecialchars($rawTitle), $content['title_settings'] ?? [], 'text-2xl font-bold text-slate-800', 'h3');
                }

                $btnActionHtml = ! empty($content['button_text']) ? '<div class="pt-2"><a href="'.htmlspecialchars($content['button_url'] ?? '#').'" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md shadow-blue-600/20">'.htmlspecialchars($content['button_text']).'</a></div>' : '';

                $descHtml = $content['description'] ?? '';
                $imgUrl = ! empty($content['image']) ? htmlspecialchars($content['image']) : '';

                if ($imgPos === 'bottom') {
                    $fullImgCol = $imgUrl ? "<div class=\"w-full mt-6 overflow-hidden rounded-2xl border border-slate-100\"><img src=\"{$imgUrl}\" class=\"w-full h-auto object-cover rounded-2xl shadow-sm\"></div>" : '';
                    $fullTxtCol = "<div class=\"w-full space-y-4 min-w-0\">
                        {$compiledTitle}
                        ".($descHtml ? "<div class=\"prose prose-lg prose-blue !break-words !break-all text-slate-600\">{$descHtml}</div>" : '')."
                        {$btnActionHtml}
                    </div>";
                    $layoutHtml = "<div class=\"flex flex-col w-full\">{$fullTxtCol}{$fullImgCol}</div>";
                } elseif ($imgPos === 'top') {
                    $fullImgCol = $imgUrl ? "<div class=\"w-full mb-6 overflow-hidden rounded-2xl border border-slate-100\"><img src=\"{$imgUrl}\" class=\"w-full h-auto object-cover rounded-2xl shadow-sm\"></div>" : '';
                    $fullTxtCol = "<div class=\"w-full space-y-4 min-w-0\">
                        {$compiledTitle}
                        ".($descHtml ? "<div class=\"prose prose-lg prose-blue !break-words !break-all text-slate-600\">{$descHtml}</div>" : '')."
                        {$btnActionHtml}
                    </div>";
                    $layoutHtml = "<div class=\"flex flex-col w-full\">{$fullImgCol}{$fullTxtCol}</div>";
                } elseif ($imgPos === 'right') {
                    $txtCol = "<div class=\"w-full md:w-2/3 space-y-4 min-w-0\">
                        {$compiledTitle}
                        <div class=\"prose prose-slate text-slate-600 leading-relaxed !break-words !break-all\">{$descHtml}</div>
                        {$btnActionHtml}
                    </div>";
                    $imgCol = $imgUrl ? "<div class=\"w-full md:w-1/3 shrink-0 rounded-2xl overflow-hidden border-4 border-white shadow-md\"><img src=\"{$imgUrl}\" class=\"w-full h-auto object-cover aspect-[4/3] hover:scale-105 transition-transform duration-500\"></div>" : '';
                    $layoutHtml = "<div class=\"flex flex-col md:flex-row-reverse gap-8 bg-white/70 backdrop-blur-lg p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 my-8 items-center\">{$imgCol}{$txtCol}</div>";
                } else {
                    $txtCol = "<div class=\"w-full md:w-2/3 space-y-4 min-w-0\">
                        {$compiledTitle}
                        <div class=\"prose prose-slate text-slate-600 leading-relaxed !break-words !break-all\">{$descHtml}</div>
                        {$btnActionHtml}
                    </div>";
                    $imgCol = $imgUrl ? "<div class=\"w-full md:w-1/3 shrink-0 rounded-2xl overflow-hidden border-4 border-white shadow-md\"><img src=\"{$imgUrl}\" class=\"w-full h-auto object-cover aspect-[4/3] hover:scale-105 transition-transform duration-500\"></div>" : '';
                    $layoutHtml = "<div class=\"flex flex-col md:flex-row gap-8 bg-white/70 backdrop-blur-lg p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 my-8 items-center\">{$imgCol}{$txtCol}</div>";
                }

                if (! empty($settings['wrapper_class'])) {
                    $layoutHtml = "<div class=\"{$settings['wrapper_class']}\">{$layoutHtml}</div>";
                }

                return $wrapperStart."\n{$layoutHtml}\n".$wrapperEnd;

            case 'image':
                $imgUrl = $content['image'] ?? '';
                if (empty($imgUrl)) {
                    return '';
                }
                $alt = htmlspecialchars($content['alt'] ?? '');
                $caption = htmlspecialchars($content['caption'] ?? '');
                $link = $content['link'] ?? '';
                $width = $content['width'] ?? 'max-w-5xl';
                $rounded = $content['rounded'] ?? 'rounded-2xl';
                $shadow = $content['shadow'] ?? 'shadow-lg';
                $align = $settings['align'] ?? 'center';

                $widthClass = match ($width) {
                    'w-full' => 'w-full max-w-6xl',
                    'max-w-5xl' => 'max-w-5xl',
                    'max-w-3xl' => 'max-w-3xl',
                    'max-w-xl' => 'max-w-xl',
                    'max-w-md' => 'max-w-md',
                    default => 'w-full max-w-5xl',
                };

                $alignClass = match ($align) {
                    'left' => 'mr-auto text-left',
                    'right' => 'ml-auto text-right',
                    default => 'mx-auto text-center',
                };

                $safeImgUrl = htmlspecialchars($imgUrl);
                $imgElement = "<img src=\"{$safeImgUrl}\" alt=\"{$alt}\" class=\"w-full h-auto {$rounded} {$shadow} object-cover\">";

                if (! empty($link)) {
                    $safeLink = htmlspecialchars($link);
                    $imgElement = "<a href=\"{$safeLink}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"block hover:opacity-95 transition-opacity\">{$imgElement}</a>";
                }

                $captionHtml = ! empty($caption) ? "<figcaption class=\"mt-3 text-sm text-slate-500 italic text-center\">{$caption}</figcaption>" : '';

                $imgInner = "<div class=\"{$widthClass} {$alignClass}\">
                        <figure class=\"inline-block w-full\">
                            {$imgElement}
                            {$captionHtml}
                        </figure>
                    </div>";
                if (! empty($settings['wrapper_class'])) {
                    $imgInner = "<div class=\"{$settings['wrapper_class']}\">{$imgInner}</div>";
                }

                return $wrapperStart."\n{$imgInner}\n".$wrapperEnd;

            case 'list':
            case 'lists':
                $heading = htmlspecialchars($content['heading'] ?? '');
                $headingSettings = $content['heading_settings'] ?? [];
                $desc = htmlspecialchars($content['description'] ?? '');
                $style = $content['style'] ?? 'check';
                $cols = (int) ($content['columns'] ?? 1);
                $items = $content['items'] ?? [];

                if (empty($heading) && empty($desc) && empty($items)) {
                    return '';
                }

                $compiledHeading = $this->compileText($heading, $headingSettings, 'text-2xl md:text-3xl font-bold text-slate-900', 'h2');
                $headingHtml = $compiledHeading ? "<div class=\"mb-3\">{$compiledHeading}</div>" : '';
                $descHtml = $desc ? "<p class=\"text-slate-600 text-sm sm:text-base mb-6 max-w-3xl\">{$desc}</p>" : '';

                $gridClass = $cols === 2 ? 'grid grid-cols-1 md:grid-cols-2 gap-3.5' : 'space-y-3';

                $itemsHtml = '';
                foreach ($items as $idx => $item) {
                    $itemTitle = htmlspecialchars($item['title'] ?? '');
                    $itemDesc = htmlspecialchars($item['description'] ?? '');
                    $itemLink = $item['link'] ?? '';

                    if (empty($itemTitle) && empty($itemDesc)) {
                        continue;
                    }

                    // Icon based on style
                    if ($style === 'number') {
                        $num = $idx + 1;
                        $iconHtml = "<span class=\"flex-shrink-0 w-7 h-7 rounded-full bg-blue-100 text-blue-600 font-bold text-xs flex items-center justify-center mt-0.5\">{$num}</span>";
                    } elseif ($style === 'arrow') {
                        $iconHtml = '<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>';
                    } elseif ($style === 'bullet') {
                        $iconHtml = '<span class="flex-shrink-0 w-7 h-7 flex items-center justify-center mt-0.5 text-blue-600 font-extrabold text-xl leading-none">•</span>';
                    } else {
                        // default check
                        $iconHtml = '<span class="flex-shrink-0 w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg></span>';
                    }

                    $titleHtml = "<span class=\"font-semibold text-slate-800 text-sm sm:text-base leading-snug\">{$itemTitle}</span>";
                    if (! empty($itemLink)) {
                        $safeLink = htmlspecialchars($itemLink);
                        $titleHtml = "<a href=\"{$safeLink}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"hover:text-blue-600 hover:underline transition-colors\">{$titleHtml}</a>";
                    }

                    $descItemHtml = ! empty($itemDesc) ? "<p class=\"text-xs text-slate-500 mt-1 leading-relaxed\">{$itemDesc}</p>" : '';

                    $itemsHtml .= "<div class=\"flex items-start gap-3.5 p-3.5 rounded-xl bg-white/70 border border-slate-100/80 shadow-xs hover:border-blue-200 transition-colors\">
                        {$iconHtml}
                        <div class=\"flex-1 min-w-0\">
                            {$titleHtml}
                            {$descItemHtml}
                        </div>
                    </div>";
                }

                $listInner = "<div class=\"max-w-4xl mx-auto\">
                        {$headingHtml}
                        {$descHtml}
                        <div class=\"{$gridClass}\">
                            {$itemsHtml}
                        </div>
                    </div>";
                if (! empty($settings['wrapper_class'])) {
                    $listInner = "<div class=\"{$settings['wrapper_class']}\">{$listInner}</div>";
                }

                return $wrapperStart."\n{$listInner}\n".$wrapperEnd;

            case 'gallery_slider':
            case 'slider':
                $heading = htmlspecialchars($content['heading'] ?? '');
                $subheading = htmlspecialchars($content['subheading'] ?? '');
                $items = $content['items'] ?? [];

                $headingHtml = $heading ? "<h2 class=\"text-3xl font-extrabold text-slate-800\">{$heading}</h2>" : '';
                $subheadingHtml = $subheading ? "<p class=\"text-slate-500 mt-2\">{$subheading}</p>" : '';
                $headerBlock = ($headingHtml || $subheadingHtml) ? "<div class=\"text-center max-w-2xl mx-auto mb-8\">{$headingHtml}{$subheadingHtml}</div>" : '';

                $cardsHtml = '';
                $loopItems = count($items) > 0 ? array_merge($items, $items) : [];
                foreach ($loopItems as $item) {
                    $img = htmlspecialchars($item['image'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop');
                    $name = htmlspecialchars($item['name'] ?? '');
                    $role = htmlspecialchars($item['role'] ?? '');

                    $cardsHtml .= "<div class=\"w-64 bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm rounded-3xl p-5 shrink-0 hover:shadow-lg transition-all duration-300 hover:-translate-y-1\">
                        <div class=\"w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-blue-500/20 mb-3\">
                            <img src=\"{$img}\" class=\"w-full h-full object-cover\" alt=\"{$name}\">
                        </div>
                        <h4 class=\"font-bold text-slate-800 text-center text-sm\">{$name}</h4>
                        <p class=\"text-xs text-blue-600 font-medium text-center\">{$role}</p>
                    </div>";
                }

                $sliderInner = "<div class=\"w-full max-w-6xl mx-auto my-8\">
                    {$headerBlock}
                    <div class=\"relative w-full overflow-hidden py-4 [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]\">
                        <div class=\"animate-marquee flex gap-6 w-max\">
                            {$cardsHtml}
                        </div>
                    </div>
                </div>";

                if (! empty($settings['wrapper_class'])) {
                    $sliderInner = "<div class=\"{$settings['wrapper_class']}\">{$sliderInner}</div>";
                }

                return $wrapperStart."\n{$sliderInner}\n".$wrapperEnd;

            case 'profile_table':
            case 'table_profile':
                $name = htmlspecialchars($content['name'] ?? '');
                $role = htmlspecialchars($content['role'] ?? '');
                $imgUrl = htmlspecialchars($content['image'] ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=500&fit=crop');
                $bio = $content['bio'] ?? '';
                $details = $content['details'] ?? [];
                $btnText = htmlspecialchars($content['button_text'] ?? '');
                $btnUrl = htmlspecialchars($content['button_url'] ?? '#');

                $rowsHtml = '';
                foreach ($details as $d) {
                    $label = htmlspecialchars($d['label'] ?? '');
                    $val = htmlspecialchars($d['value'] ?? '');
                    $rowsHtml .= "<tr>
                        <th class=\"py-2.5 px-4 font-semibold text-slate-500 w-1/3 bg-slate-50/60\">{$label}</th>
                        <td class=\"py-2.5 px-4 text-slate-800 font-medium\">{$val}</td>
                    </tr>";
                }

                $btnHtml = $btnText ? "<div class=\"mt-4 text-center\"><a href=\"{$btnUrl}\" class=\"inline-flex items-center gap-1.5 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition-all\">{$btnText}</a></div>" : '';

                $profileInner = "<div class=\"w-full max-w-5xl mx-auto my-8\">
                    <div class=\"bg-white/80 backdrop-blur-xl border border-slate-200/80 rounded-3xl shadow-sm p-6 sm:p-8 flex flex-col md:flex-row gap-8 items-start\">
                        <div class=\"w-full md:w-1/3 shrink-0 flex flex-col items-center\">
                            <div class=\"w-48 h-56 sm:w-56 sm:h-64 rounded-2xl overflow-hidden border-4 border-white shadow-md bg-slate-100 mb-4\">
                                <img src=\"{$imgUrl}\" class=\"w-full h-full object-cover\" alt=\"{$name}\">
                            </div>
                            <h3 class=\"text-xl font-bold text-slate-800 text-center\">{$name}</h3>
                            <p class=\"text-xs font-semibold text-blue-600 text-center mt-1\">{$role}</p>
                            {$btnHtml}
                        </div>
                        <div class=\"w-full md:w-2/3 min-w-0 space-y-4\">
                            <div class=\"border-b border-slate-100 pb-3\">
                                <h4 class=\"text-lg font-bold text-slate-800\">Biodata &amp; Informasi Pegawai</h4>
                                <p class=\"text-xs text-slate-500 mt-0.5\">Informasi resmi jabatan dan kepegawaian BPMP Sultra</p>
                            </div>
                            ".($bio ? "<p class=\"text-sm text-slate-600 leading-relaxed\">{$bio}</p>" : '')."
                            <div class=\"rounded-2xl border border-slate-100 overflow-hidden bg-white/50\">
                                <table class=\"w-full text-left text-xs sm:text-sm\">
                                    <tbody class=\"divide-y divide-slate-100\">
                                        {$rowsHtml}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>";

                if (! empty($settings['wrapper_class'])) {
                    $profileInner = "<div class=\"{$settings['wrapper_class']}\">{$profileInner}</div>";
                }

                return $wrapperStart."\n{$profileInner}\n".$wrapperEnd;

            default:
                return '';
        }
    }
}
