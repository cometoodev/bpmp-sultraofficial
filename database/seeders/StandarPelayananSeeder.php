<?php

namespace Database\Seeders;

use App\Models\StandarPelayanan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StandarPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storageDir = storage_path('app/public/standar-pelayanan');
        if (! File::isDirectory($storageDir)) {
            File::makeDirectory($storageDir, 0755, true);
        }

        $documents = [
            [
                'title' => 'Maklumat Pelayanan BPMP Provinsi Sulawesi Tenggara',
                'filename' => '01-maklumat-pelayanan.pdf',
                'padding' => 1250000, // ~1.2 MB
                'date' => Carbon::now()->subMonths(3),
            ],
            [
                'title' => 'Standar Pelayanan Permohonan Informasi Publik (PPID)',
                'filename' => '02-standar-pelayanan-informasi-ppid.pdf',
                'padding' => 2450000, // ~2.4 MB
                'date' => Carbon::now()->subMonths(2)->subDays(10),
            ],
            [
                'title' => 'Standar Pelayanan Pengaduan Masyarakat',
                'filename' => '03-standar-pelayanan-pengaduan-masyarakat.pdf',
                'padding' => 1850000, // ~1.8 MB
                'date' => Carbon::now()->subMonths(2),
            ],
            [
                'title' => 'Standar Pelayanan Konsultasi dan Fasilitasi Mutu Pendidikan',
                'filename' => '04-standar-pelayanan-konsultasi-fasilitasi-mutu.pdf',
                'padding' => 3100000, // ~3.1 MB
                'date' => Carbon::now()->subMonth()->subDays(15),
            ],
            [
                'title' => 'Standar Pelayanan Pemanfaatan Wisma, Sarana, dan Prasarana',
                'filename' => '05-standar-pelayanan-peminjaman-fasilitas.pdf',
                'padding' => 2900000, // ~2.9 MB
                'date' => Carbon::now()->subMonth()->subDays(10),
            ],
            [
                'title' => 'Standar Pelayanan Legalisasi Dokumen dan Ijazah',
                'filename' => '06-standar-pelayanan-legalisasi-ijazah.pdf',
                'padding' => 950000, // ~950 KB
                'date' => Carbon::now()->subMonth()->subDays(5),
            ],
            [
                'title' => 'Standar Pelayanan Pemetaan dan Supervisi Mutu Satuan Pendidikan',
                'filename' => '07-standar-pelayanan-supervisi-mutu.pdf',
                'padding' => 3400000, // ~3.4 MB
                'date' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Standar Pelayanan Kerjasama Kemitraan dan Penjaminan Mutu',
                'filename' => '08-standar-pelayanan-kemitraan.pdf',
                'padding' => 1650000, // ~1.6 MB
                'date' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Standar Pelayanan Magang / Prakerin / Penelitian',
                'filename' => '09-standar-pelayanan-magang-prakerin-penelitian.pdf',
                'padding' => 1400000, // ~1.4 MB
                'date' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($documents as $doc) {
            $filePath = $storageDir.DIRECTORY_SEPARATOR.$doc['filename'];

            // Generate valid PDF content with realistic padding bytes
            $pdfContent = "%PDF-1.4\n"
                ."1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n"
                ."2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n"
                ."3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>/Contents 4 0 R>>endobj\n"
                .'4 0 obj<</Length '.(strlen($doc['title']) + 50).">>stream\n"
                .'BT /F1 20 Tf 50 720 Td ('.str_replace(['(', ')'], '', $doc['title']).") Tj ET\n"
                ."endstream\nendobj\n"
                .'% '.str_repeat('X', max(100, $doc['padding'] - 400))."\n"
                ."xref\n0 5\n0000000000 65535 f \n0000000009 00000 n \n0000000052 00000 n \n0000000108 00000 n \n0000000201 00000 n \n"
                ."trailer<</Size 5/Root 1 0 R>>\nstartxref\n350\n%%EOF\n";

            File::put($filePath, $pdfContent);

            $bytes = filesize($filePath);
            $sizeFormatted = $bytes >= 1048576
                ? number_format($bytes / 1048576, 2).' MB'
                : number_format($bytes / 1024, 2).' KB';

            StandarPelayanan::updateOrCreate(
                ['title' => $doc['title']],
                [
                    'file_path' => asset('storage/standar-pelayanan/'.$doc['filename']),
                    'file_size' => $sizeFormatted,
                    'uploaded_at' => $doc['date'],
                ]
            );
        }
    }
}
