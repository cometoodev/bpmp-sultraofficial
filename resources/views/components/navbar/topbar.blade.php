<!-- Top Bar -->
<div class="hidden lg:flex items-center justify-between w-full px-6 lg:px-12 py-1.5 bg-blue-900 text-white text-xs md:text-sm border-b border-blue-800/60 transition-all duration-300"
     :class="scrolled ? 'h-0 py-0 opacity-0 overflow-hidden border-none' : 'h-auto opacity-100'">
    
    <!-- Left: Email -->
    <div class="flex items-center gap-2 font-medium opacity-95 hover:opacity-100 transition-opacity whitespace-nowrap">
        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <a href="mailto:bpmpsultra@kemendikdasmen.go.id" class="tracking-wide text-white hover:text-blue-200 transition-colors">bpmpsultra@kemendikdasmen.go.id</a>
    </div>
    
    <!-- Center: Marquee -->
    <div class="flex-1 px-8 overflow-hidden relative flex items-center justify-center">
        <div class="w-full max-w-2xl overflow-hidden relative">
            <p class="animate-marquee tracking-wide text-white font-medium">
                Selamat Datang di Portal Resmi Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara &mdash; Menjamin Mutu Pendidikan Berkualitas dan Merata
            </p>
        </div>
    </div>

    <!-- Right: Social Icons -->
    <div class="flex items-center gap-2.5 shrink-0 text-white">
        <a href="https://www.tiktok.com/@bpmp.sulawesitenggara" target="_blank" rel="noopener noreferrer" title="TikTok BPMP Sultra" class="p-1.5 rounded-full bg-white/10 hover:bg-white/25 transition-all text-white hover:text-blue-200">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.24-2.61.94-5.22 3.02-6.72 1.02-.74 2.27-1.15 3.51-1.25V13.3c-1.05.08-2.1.51-2.9 1.19-1.07 1.05-1.57 2.62-1.27 4.1.28 1.25 1.15 2.37 2.29 2.96 1.21.6 2.68.62 3.91.07 1.57-.75 2.5-2.39 2.55-4.14.08-3.41.03-6.82.04-10.23h-.01z"/></svg>
        </a>
        <a href="https://www.instagram.com/bpmpsultra/" target="_blank" rel="noopener noreferrer" title="Instagram BPMP Sultra" class="p-1.5 rounded-full bg-white/10 hover:bg-white/25 transition-all text-white hover:text-pink-300">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.67 4.77-4.92 4.92-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85c.15-3.23 1.66-4.77 4.92-4.92 1.27-.06 1.64-.07 4.85-.07zm0-2.16C8.74 0 8.33.01 7.05.07 2.7.27.27 2.69.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.62-6.78-6.98-6.98C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 100 12.32 6.16 6.16 0 000-12.32zM12 16a4 4 0 110-8 4 4 0 010 8zm6.41-11.85a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88z"/></svg>
        </a>
        <a href="https://www.youtube.com/@bpmpsultra" target="_blank" rel="noopener noreferrer" title="YouTube BPMP Sultra" class="p-1.5 rounded-full bg-white/10 hover:bg-white/25 transition-all text-white hover:text-red-400">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.19a3 3 0 00-2.11-2.13C19.53 3.5 12 3.5 12 3.5s-7.53 0-9.39.56A3 3 0 00.5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3 3 0 002.11 2.13c1.86.56 9.39.56 9.39.56s7.53 0 9.39-.56a3 3 0 002.11-2.13c.5-1.88.5-5.81.5-5.81s0-3.93-.5-5.81zM9.55 15.56V8.44L15.64 12l-6.09 3.56z"/></svg>
        </a>
    </div>
</div>
