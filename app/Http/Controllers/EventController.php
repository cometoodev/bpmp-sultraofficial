<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display the public listing of events and webinars ("Lihat Semua" page).
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $type = $request->query('type');

        $query = Event::orderBy('event_date', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%");
            });
        }

        if ($type && in_array($type, ['Webinar', 'Event'], true)) {
            $query->where('type', $type);
        }

        $events = $query->paginate(6)->withQueryString();

        return view('pages.events-webinar', compact('events', 'search', 'type'));
    }

    /**
     * Display a listing of the resource in the CMS Admin.
     */
    public function adminIndex(): View
    {
        $events = Event::orderBy('event_date', 'desc')->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Store a newly created event or webinar in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Webinar,Event',
            'event_date' => 'required|date',
            'organizer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'instagram_url' => 'required|url',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->back()->with('success', 'Event atau Webinar berhasil ditambahkan!');
    }

    /**
     * Update the specified event or webinar in storage.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Webinar,Event',
            'event_date' => 'required|date',
            'organizer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'instagram_url' => 'required|url',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->back()->with('success', 'Data Event / Webinar berhasil diperbarui!');
    }

    /**
     * Remove the specified event or webinar from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
