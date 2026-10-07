<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Page::query()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
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

        if (($validated['editor_mode'] ?? 'html') === 'visual' && ! empty($validated['builder_data'])) {
            $validated['content'] = $this->compileBuilderData($validated['builder_data']);
        }

        $page = Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$page->title}' berhasil dibuat.");
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();

        if ($validated['status'] === 'published' && empty($validated['published_at']) && empty($page->published_at)) {
            $validated['published_at'] = now();
        }

        if (($validated['editor_mode'] ?? 'html') === 'visual' && ! empty($validated['builder_data'])) {
            $validated['content'] = $this->compileBuilderData($validated['builder_data']);
        }

        $page->update($validated);

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

        $validated['content'] = $this->compileBuilderData($validated['builder_data'] ?? '[]');

        $page->update([
            'builder_data' => $validated['builder_data'],
            'editor_mode' => $validated['editor_mode'],
            'content' => $validated['content'],
        ]);

        return response()->json(['success' => true]);
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

    private function compileBuilderData(string $json): string
    {
        $data = json_decode($json, true);
        if (! is_array($data)) {
            return '';
        }

        $html = '';
        foreach ($data as $block) {
            $type = $block['type'] ?? '';
            $content = $block['content'] ?? [];
            $settings = $block['settings'] ?? [];

            // Compile settings into classes
            $classes = [];
            if (! empty($settings['bg'])) {
                $classes[] = $settings['bg'] === 'white' ? 'bg-white' : ($settings['bg'] === 'gray' ? 'bg-slate-50' : 'bg-blue-50');
            }
            if (! empty($settings['padding'])) {
                $classes[] = $settings['padding'] === 'small' ? 'py-8' : ($settings['padding'] === 'large' ? 'py-24' : 'py-16');
            }
            if (! empty($settings['align'])) {
                $classes[] = 'text-'.$settings['align'];
            }

            $classStr = implode(' ', $classes);
            $wrapperStart = "<section class=\"{$classStr}\"><div class=\"container mx-auto px-4\">";
            $wrapperEnd = '</div></section>';

            switch ($type) {
                case 'hero':
                    $title = $content['title'] ?? '';
                    $titleSettings = $content['title_settings'] ?? [];
                    $desc = $content['description'] ?? '';
                    $descSettings = $content['description_settings'] ?? [];
                    $btnTxt = htmlspecialchars($content['button_text'] ?? '');
                    $btnUrl = htmlspecialchars($content['button_url'] ?? '#');

                    $compiledTitle = $this->compileText(htmlspecialchars($title), $titleSettings, 'text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight', 'h1');
                    $compiledDesc = $this->compileText(htmlspecialchars($desc), $descSettings, 'text-lg text-slate-600');

                    $btnHtml = $btnTxt ? "<div class=\"pt-4\"><a href=\"{$btnUrl}\" class=\"inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5\">{$btnTxt}</a></div>" : '';

                    $html .= $wrapperStart."
                        <div class=\"max-w-4xl mx-auto text-center space-y-6\">
                            {$compiledTitle}
                            {$compiledDesc}
                            {$btnHtml}
                        </div>
                    ".$wrapperEnd;
                    break;

                case 'text':
                    $textContent = $content['html'] ?? '';
                    $html .= $wrapperStart."
                        <div class=\"prose prose-lg max-w-4xl mx-auto prose-blue !break-words !break-all overflow-hidden\">
                            {$textContent}
                        </div>
                    ".$wrapperEnd;
                    break;

                case 'cards':
                    $cols = $content['columns'] ?? 3;
                    $gridClass = $cols == 2 ? 'md:grid-cols-2' : ($cols == 4 ? 'md:grid-cols-2 lg:grid-cols-4' : 'md:grid-cols-3');

                    $compiledHeading = $this->compileText(htmlspecialchars($content['heading'] ?? ''), $content['heading_settings'] ?? [], 'text-3xl font-bold text-slate-900', 'h2');

                    $headingHtml = $compiledHeading ? "<div class=\"text-center mb-12\">{$compiledHeading}</div>" : '';

                    $html .= $wrapperStart."
                        {$headingHtml}
                        <div class=\"grid grid-cols-1 {$gridClass} gap-6\">";

                    foreach ($content['items'] ?? [] as $item) {
                        $compiledItemTitle = $this->compileText(htmlspecialchars($item['title'] ?? ''), $item['title_settings'] ?? [], 'text-xl font-bold text-slate-900 mb-2', 'h3');
                        $compiledItemDesc = $this->compileText(htmlspecialchars($item['description'] ?? ''), $item['description_settings'] ?? [], 'text-slate-600 mb-4 flex-grow');

                        $imgHtml = ! empty($item['image']) ? '<img src="'.htmlspecialchars($item['image']).'" class="w-full h-48 object-cover">' : '';
                        $btnItemHtml = ! empty($item['button_text']) ? '<div class="mt-auto"><a href="'.htmlspecialchars($item['button_url'] ?? '#').'" class="text-blue-600 font-bold hover:text-blue-700 inline-flex items-center gap-1">'.htmlspecialchars($item['button_text']).' <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></div>' : '';

                        $html .= "<div class=\"bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 overflow-hidden flex flex-col\">
                            {$imgHtml}
                            <div class=\"p-6 flex-grow flex flex-col\">
                                {$compiledItemTitle}
                                {$compiledItemDesc}
                                {$btnItemHtml}
                            </div>
                        </div>";
                    }

                    $html .= '</div>'.$wrapperEnd;
                    break;

                case 'image_text':
                    $imgPos = $settings['image_position'] ?? 'left';
                    $imgCol = '<div class="w-full lg:w-1/2"><img src="'.htmlspecialchars($content['image'] ?? '').'" class="w-full rounded-2xl shadow-lg"></div>';

                    $compiledTitle = $this->compileText(htmlspecialchars($content['title'] ?? ''), $content['title_settings'] ?? [], 'text-3xl lg:text-4xl font-bold text-slate-900', 'h2');

                    $btnActionHtml = ! empty($content['button_text']) ? '<div class="pt-2"><a href="'.htmlspecialchars($content['button_url'] ?? '#').'" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all">'.htmlspecialchars($content['button_text']).'</a></div>' : '';

                    $descHtml = $content['description'] ?? '';

                    $txtCol = "<div class=\"w-full lg:w-1/2 space-y-6 min-w-0\">
                        {$compiledTitle}
                        <div class=\"prose prose-lg prose-blue !break-words !break-all text-slate-600\">{$descHtml}</div>
                        {$btnActionHtml}
                    </div>";

                    $layoutHtml = ($imgPos === 'left' ? $imgCol.$txtCol : $txtCol.$imgCol);

                    $html .= $wrapperStart."
                        <div class=\"flex flex-col lg:flex-row items-center gap-12\">
                            {$layoutHtml}
                        </div>
                    ".$wrapperEnd;
                    break;
            }
        }

        return $html;
    }
}
