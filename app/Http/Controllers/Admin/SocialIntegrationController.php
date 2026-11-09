<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialIntegration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialIntegrationController extends Controller
{
    /**
     * Menampilkan halaman manajemen integrasi media sosial di Admin CMS.
     */
    public function index(): View
    {
        // Pastikan default 3 platform selalu ada
        $platforms = [
            'instagram' => ['name' => 'Instagram', 'username' => '@bpmpsultra', 'profile_url' => 'https://www.instagram.com/bpmpsultra/', 'order' => 1],
            'tiktok' => ['name' => 'TikTok', 'username' => '@bpmp.sulawesitenggara', 'profile_url' => 'https://www.tiktok.com/@bpmp.sulawesitenggara', 'order' => 2],
            'youtube' => ['name' => 'YouTube', 'username' => '@bpmpsultra', 'profile_url' => 'https://www.youtube.com/@bpmpsultra', 'order' => 3],
        ];

        foreach ($platforms as $key => $default) {
            SocialIntegration::firstOrCreate(
                ['platform' => $key],
                [
                    'name' => $default['name'],
                    'username' => $default['username'],
                    'profile_url' => $default['profile_url'],
                    'embed_code' => null,
                    'is_active' => true,
                    'order' => $default['order'],
                ]
            );
        }

        $socials = SocialIntegration::orderBy('order', 'asc')->get();

        return view('admin.social.index', compact('socials'));
    }

    /**
     * Memperbarui pengaturan platform media sosial.
     */
    public function update(Request $request, SocialIntegration $socialIntegration): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'nullable|string|max:100',
            'profile_url' => 'nullable|url|max:255',
            'embed_code' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'username.max' => 'Username/handle maksimal 100 karakter.',
            'profile_url.url' => 'Tautan profil harus berformat URL valid (contoh: https://...).',
        ]);

        $socialIntegration->update([
            'username' => $validated['username'] ?? null,
            'profile_url' => $validated['profile_url'] ?? null,
            'embed_code' => $validated['embed_code'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.social.index')->with('success', "Pengaturan integrasi {$socialIntegration->name} berhasil diperbarui!");
    }
}
