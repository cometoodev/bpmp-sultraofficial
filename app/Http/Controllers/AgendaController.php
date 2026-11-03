<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    /**
     * Display a listing of the agendas in admin CMS.
     */
    public function index(): View
    {
        $agendas = Agenda::orderBy('agenda_date', 'asc')
            ->orderBy('time_start', 'asc')
            ->paginate(10);

        return view('admin.agendas.index', compact('agendas'));
    }

    /**
     * Store a newly created agenda in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'agenda_date' => 'required|date',
            'time_start' => 'required|string|max:50',
            'time_end' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        Agenda::create($validated);

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil ditambahkan!');
    }

    /**
     * Update the specified agenda in storage.
     */
    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'agenda_date' => 'required|date',
            'time_start' => 'required|string|max:50',
            'time_end' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $agenda->update($validated);

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified agenda from storage.
     */
    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()->back()->with('success', 'Agenda berhasil dihapus.');
    }
}
