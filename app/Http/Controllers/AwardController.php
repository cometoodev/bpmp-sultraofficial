<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AwardController extends Controller
{
    /**
     * Display a listing of awards for CMS admin management.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Award::orderBy('order', 'asc')->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('badge', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $awards = $query->paginate(10)->withQueryString();

        return view('admin.awards.index', compact('awards', 'search'));
    }

    /**
     * Store a newly created award in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('awards', 'public');
        }

        Award::create([
            'title' => $validated['title'],
            'badge' => $validated['badge'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.awards.index')->with('success', 'Data Maklumat / Penghargaan berhasil ditambahkan!');
    }

    /**
     * Update the specified award in storage.
     */
    public function update(Request $request, Award $award): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($award->image && Storage::disk('public')->exists($award->image)) {
                Storage::disk('public')->delete($award->image);
            }
            $award->image = $request->file('image')->store('awards', 'public');
        }

        $award->title = $validated['title'];
        $award->badge = $validated['badge'];
        $award->description = $validated['description'];
        $award->order = $validated['order'] ?? $award->order;
        $award->save();

        return redirect()->route('admin.awards.index')->with('success', 'Data Maklumat / Penghargaan berhasil diperbarui!');
    }

    /**
     * Remove the specified award from storage.
     */
    public function destroy(Award $award): RedirectResponse
    {
        if ($award->image && Storage::disk('public')->exists($award->image)) {
            Storage::disk('public')->delete($award->image);
        }

        $award->delete();

        return redirect()->route('admin.awards.index')->with('success', 'Data Maklumat / Penghargaan berhasil dihapus.');
    }
}
