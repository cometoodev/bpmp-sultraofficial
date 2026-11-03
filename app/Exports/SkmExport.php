<?php

namespace App\Exports;

use App\Models\Guestbook;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkmExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @param  Collection<int, Guestbook>|null  $guestbooks
     */
    public function __construct(
        protected ?Collection $guestbooks = null,
    ) {}

    public function collection(): Collection
    {
        return $this->guestbooks ?? Guestbook::with('ultSurveyResponse')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Timestamp',
            'Nama',
            'Jenis Kelamin',
            'Usia',
            'Nomor Telepon/HP/WA',
            'Pendidikan Terakhir',
            'Pekerjaan',
            'Status Kepegawaian',
            'Asal Instansi',
            'Asal Kabupaten/Kota',
            'Jenis Layanan yang Diperoleh',
            'Silahkan beri penilaian terhadap layanan kami [Kesesuaian persyaratan pelayanan dengan jenis pelayanan]',
            'Silahkan beri penilaian terhadap layanan kami [Kemudahan prosedur pelayanan]',
            'Silahkan beri penilaian terhadap layanan kami [Kecepatan waktu dalam memberikan pelayanan]',
            'Silahkan beri penilaian terhadap layanan kami [Tidak dikenakan biaya/tarif dalam pelayanan]',
            'Silahkan beri penilaian terhadap layanan kami [Kesesuaian produk layanan dengan kebutuhan]',
            'Silahkan beri penilaian terhadap layanan kami [Kompetensi petugas layanan]',
            'Silahkan beri penilaian terhadap layanan kami [Sikap/perilaku petugas dalam memberikan pelayanan ]',
            'Silahkan beri penilaian terhadap layanan kami [Kualitas sarana dan prasarana]',
            'Silahkan beri penilaian terhadap layanan kami [Penanganan pengaduan]',
            'Berikan Saran dan Masukan',
        ];
    }

    public function map($guestbook): array
    {
        // Pastikan relasi kuisioner di-load
        $skm = $guestbook->ultSurveyResponse;

        // Helper untuk mengubah angka database (1-4) kembali menjadi teks Google Form
        $konversiTeks = function ($skor) {
            if ($skor == 4) {
                return 'Sangat Puas';
            }
            if ($skor == 3) {
                return 'Puas';
            }
            if ($skor == 2) {
                return 'Tidak Puas';
            }
            if ($skor == 1) {
                return 'Sangat Tidak Puas';
            }

            return '';
        };

        // Format waktu Google Form: M/D/YYYY H:mm:ss (contoh: 7/27/2026 8:33:54)
        $waktu = $guestbook->created_at ? $guestbook->created_at->format('n/j/Y G:i:s') : '';

        // Sesuaikan format Jenis Kelamin
        $jk = $guestbook->jenis_kelamin;
        if (strtoupper($jk) == 'L') {
            $jk = 'Laki-laki';
        }
        if (strtoupper($jk) == 'P') {
            $jk = 'Perempuan';
        }

        return [
            $waktu,
            $guestbook->nama,
            $jk,
            $guestbook->usia,
            $guestbook->telepon,
            $guestbook->pendidikan,
            $guestbook->pekerjaan,
            $guestbook->status_kepegawaian,
            $guestbook->asal_instansi,
            $guestbook->asal_kabupaten,
            $guestbook->jenis_layanan,
            $skm ? $konversiTeks($skm->q1) : '',
            $skm ? $konversiTeks($skm->q2) : '',
            $skm ? $konversiTeks($skm->q3) : '',
            $skm ? $konversiTeks($skm->q4) : '',
            $skm ? $konversiTeks($skm->q5) : '',
            $skm ? $konversiTeks($skm->q6) : '',
            $skm ? $konversiTeks($skm->q7) : '',
            $skm ? $konversiTeks($skm->q8) : '',
            $skm ? $konversiTeks($skm->q9) : '',
            $skm ? $skm->saran : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Tambahkan AutoFilter (tombol panah dropdown) di seluruh baris pertama
        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

        // 2. Tidak usah pakai warna/style aneh-aneh, cukup Plain + AutoFilter
        return [];
    }
}
