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
        $pages = Page::where('status', 'published')->get();

        return view('admin.menus.create', compact('parentMenus', 'pages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer',
            'target' => 'required|in:_self,_blank',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu): View
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('order', 'asc')->get();
        $pages = Page::where('status', 'published')->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus', 'pages'));
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer',
            'target' => 'required|in:_self,_blank',
            'status' => 'boolean',
        ]);

        // Prevent setting itself as parent
        if ($validated['parent_id'] == $menu->id) {
            $validated['parent_id'] = null;
        }

        $validated['status'] = $request->has('status');

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete(); // child will be deleted due to cascade

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
