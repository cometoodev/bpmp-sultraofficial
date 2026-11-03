<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->orderBy('order', 'asc');
            }])
            ->orderBy('order', 'asc')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order', 'asc')->get();
        $pages = Page::where('status', 'published')->orderBy('title', 'asc')->get();

        return view('admin.menus.create', compact('parentMenus', 'pages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $url = $request->input('link_type') === 'custom'
            ? ($request->input('url_custom') ?: $request->input('url'))
            : ($request->input('url') ?: $request->input('url_page') ?: $request->input('url_custom'));

        $request->merge(['url' => $url]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer',
            'target' => 'nullable|in:_self,_blank',
            'status' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['order'] = $request->input('order', 0) ?? 0;
        $validated['target'] = $request->input('target', '_self') ?? '_self';
        $validated['status'] = $request->has('status') || $request->has('is_active') || ! $request->exists('_has_status_field');

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu navigasi berhasil ditambahkan dan disinkronkan!');
    }

    public function edit(Menu $menu): View
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('order', 'asc')->get();
        $pages = Page::where('status', 'published')->orderBy('title', 'asc')->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus', 'pages'));
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $url = $request->input('link_type') === 'custom'
            ? ($request->input('url_custom') ?: $request->input('url'))
            : ($request->input('url') ?: $request->input('url_page') ?: $request->input('url_custom'));

        $request->merge(['url' => $url]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer',
            'target' => 'nullable|in:_self,_blank',
            'status' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Prevent setting itself as parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $menu->id) {
            $validated['parent_id'] = null;
        }

        $validated['order'] = $request->input('order', $menu->order ?? 0) ?? 0;
        $validated['target'] = $request->input('target', $menu->target ?? '_self') ?? '_self';

        if ($request->has('status') || $request->has('is_active')) {
            $validated['status'] = true;
        } elseif ($request->exists('_has_status_field')) {
            $validated['status'] = false;
        } else {
            $validated['status'] = $menu->status ?? true;
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu navigasi dan sub-judul berhasil diperbarui!');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete(); // child will be deleted due to cascade

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
