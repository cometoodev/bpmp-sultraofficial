<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyTemplateExport implements FromArray, ShouldAutoSize, WithHeadings
{
    /**
     * Headings untuk template kuesioner SKM Permenpan RB 14/2017.
     *
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Usia',
            'Pekerjaan',
            'U1',
            'U2',
            'U3',
            'U4',
            'U5',
            'U6',
            'U7',
            'U8',
            'U9',
        ];
    }

    /**
     * Contoh baris data untuk panduan pengisian (nilai 1 - 4).
     *
     * @return array<int, array<int, mixed>>
     */
    public function array(): array
    {
        return [
            ['Ahmad Fauzi', 34, 'Guru / Tenaga Pendidik', 4, 3, 3, 4, 4, 3, 4, 3, 4],
            ['Siti Rahmawati', 28, 'PNS Dinas Pendidikan', 3, 4, 3, 4, 3, 4, 3, 4, 3],
            ['Budi Santoso', 45, 'Kepala Sekolah', 4, 4, 4, 4, 4, 4, 4, 3, 4],
        ];
    }
}
