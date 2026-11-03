<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UltSurveyController extends Controller
{
    /**
     * Tampilkan form kuisioner untuk tamu yang sudah check-in.
     */
    public function create(int $guestbookId): View
    {
        $guestbook = Guestbook::findOrFail($guestbookId);

        // Jika sudah mengisi kuisioner, langsung ke halaman terima kasih
        if ($guestbook->surveyResponse()->exists()) {
            return view('survey.thanks', compact('guestbook'));
        }

        return view('survey.create', compact('guestbook'));
    }

    /**
     * Simpan jawaban kuisioner.
     */
    public function store(Request $request, int $guestbookId): RedirectResponse
    {
        $guestbook = Guestbook::findOrFail($guestbookId);

        $validated = $request->validate([
            'q1' => ['required', 'integer', 'min:1', 'max:4'],
            'q2' => ['required', 'integer', 'min:1', 'max:4'],
            'q3' => ['required', 'integer', 'min:1', 'max:4'],
            'q4' => ['required', 'integer', 'min:1', 'max:4'],
            'q5' => ['required', 'integer', 'min:1', 'max:4'],
            'q6' => ['required', 'integer', 'min:1', 'max:4'],
            'q7' => ['required', 'integer', 'min:1', 'max:4'],
            'q8' => ['required', 'integer', 'min:1', 'max:4'],
            'q9' => ['required', 'integer', 'min:1', 'max:4'],
            'saran' => ['nullable', 'string', 'max:2000'],
        ]);

        UltSurveyResponse::updateOrCreate(
            ['guestbook_id' => $guestbook->id],
            $validated + ['guestbook_id' => $guestbook->id],
        );

        return redirect()->route('survey.thanks');
    }
}
