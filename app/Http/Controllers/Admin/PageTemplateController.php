<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $templates = PageTemplate::query()
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($templates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'content' => 'required|string',
        ]);

        $maxSortOrder = PageTemplate::max('sort_order') ?? 0;
        $validated['sort_order'] = $maxSortOrder + 1;

        $template = PageTemplate::create($validated);

        return response()->json([
            'message' => 'Template berhasil dibuat.',
            'data' => $template,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int|string $id): JsonResponse
    {
        $template = PageTemplate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'content' => 'required|string',
        ]);

        $template->update($validated);

        return response()->json([
            'message' => 'Template berhasil diperbarui.',
            'data' => $template,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int|string $id): JsonResponse
    {
        $template = PageTemplate::findOrFail($id);
        $template->delete();

        return response()->json([
            'message' => 'Template berhasil dihapus.',
        ]);
    }

    /**
     * Reorder templates.
     */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:page_templates,id',
        ]);

        foreach ($validated['ids'] as $index => $id) {
            PageTemplate::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'message' => 'Urutan template berhasil diperbarui.',
        ]);
    }
}
