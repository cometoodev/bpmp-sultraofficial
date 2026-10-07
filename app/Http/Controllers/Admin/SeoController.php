<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $settings = DB::table('settings')->where('group', 'seo')->pluck('value', 'key');

        return view('admin.seo.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key, 'group' => 'seo'],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        return redirect()->route('admin.seo.index')
            ->with('success', 'Pengaturan SEO berhasil diperbarui.');
    }
}
