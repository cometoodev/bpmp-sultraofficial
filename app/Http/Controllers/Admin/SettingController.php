<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = DB::table('settings')->where('group', 'general')->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key, 'group' => 'general'],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
