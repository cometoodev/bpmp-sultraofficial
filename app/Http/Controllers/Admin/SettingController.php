<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = DB::table('settings')->where('group', 'general')->pluck('value', 'key');
        $mediaPhotos = DB::table('media')->where('mime_type', 'like', 'image/%')->latest()->get();

        return view('admin.settings.index', compact('settings', 'mediaPhotos'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'leader_1_photo' => 'nullable|file|mimes:jpeg,png,jpg,webp,avif,gif,svg|max:10240',
            'leader_2_photo' => 'nullable|file|mimes:jpeg,png,jpg,webp,avif,gif,svg|max:10240',
            'leader_1_media_choice' => 'nullable|string|max:255',
            'leader_2_media_choice' => 'nullable|string|max:255',
        ]);

        // Ensure leaders directory exists
        if (! Storage::disk('public')->exists('leaders')) {
            Storage::disk('public')->makeDirectory('leaders');
        }

        // Handle photo removal
        if ($request->boolean('remove_leader_1_photo')) {
            $oldPath = DB::table('settings')->where('key', 'leader_1_photo')->value('value');
            if ($oldPath && Str::startsWith($oldPath, 'leaders/') && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            DB::table('settings')->updateOrInsert(
                ['key' => 'leader_1_photo', 'group' => 'general'],
                ['value' => null, 'updated_at' => now()]
            );
        }

        if ($request->boolean('remove_leader_2_photo')) {
            $oldPath = DB::table('settings')->where('key', 'leader_2_photo')->value('value');
            if ($oldPath && Str::startsWith($oldPath, 'leaders/') && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            DB::table('settings')->updateOrInsert(
                ['key' => 'leader_2_photo', 'group' => 'general'],
                ['value' => null, 'updated_at' => now()]
            );
        }

        // Handle photo upload or selection
        $fileKeys = [
            'leader_1_photo' => 'leader_1_media_choice',
            'leader_2_photo' => 'leader_2_media_choice',
        ];

        foreach ($fileKeys as $fileKey => $mediaKey) {
            if ($request->hasFile($fileKey)) {
                $oldPath = DB::table('settings')->where('key', $fileKey)->value('value');
                if ($oldPath && Str::startsWith($oldPath, 'leaders/') && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file($fileKey)->store('leaders', 'public');
                DB::table('settings')->updateOrInsert(
                    ['key' => $fileKey, 'group' => 'general'],
                    ['value' => $path, 'updated_at' => now()]
                );
            } elseif ($request->filled($mediaKey) && ! $request->boolean('remove_'.$fileKey)) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $fileKey, 'group' => 'general'],
                    ['value' => $request->input($mediaKey), 'updated_at' => now()]
                );
            }
        }

        $data = $request->except([
            '_token',
            '_method',
            'leader_1_photo',
            'leader_2_photo',
            'leader_1_media_choice',
            'leader_2_media_choice',
            'remove_leader_1_photo',
            'remove_leader_2_photo',
        ]);

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
