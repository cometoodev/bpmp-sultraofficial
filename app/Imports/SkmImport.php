<?php

namespace App\Imports;

use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SkmImport implements ToCollection, WithHeadingRow
{
    public $batchId;

    public $importedCount = 0;

    public $skippedCount = 0;

    public function __construct($batchId = null)
    {
        $this->batchId = $batchId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // 1. CARI KOLOM NAMA & WAKTU SECARA DINAMIS
            $nama = $row['nama_pengunjung'] ?? $row['nama'] ?? $row['name'] ?? null;
            $rawWaktu = $row['tanggal_waktu'] ?? $row['timestamp'] ?? $row['waktu'] ?? null;

            if (empty($nama) && empty($rawWaktu)) {
                continue; // Abaikan baris Excel yang benar-benar kosong
            }

            if (is_numeric($nama)) {
                $nama = 'Anonim';
            }

            // 2. PARSING WAKTU DENGAN AMAN
            $createdAt = now();
            if (! empty($rawWaktu)) {
                try {
                    if (is_numeric($rawWaktu)) {
                        $createdAt = Carbon::instance(Date::excelToDateTimeObject($rawWaktu));
                    } else {
                        try {
                            $createdAt = Carbon::parse(trim($rawWaktu));
                        } catch (\Throwable $e) {
                            $cleanDate = str_replace('/', '-', trim($rawWaktu));
                            $createdAt = Carbon::parse($cleanDate);
                        }
                    }
                } catch (\Exception $e) {
                    $createdAt = now();
                }
            }

            // 3. DATA DUPLIKAT TETAP DIIZINKAN MASUK (Akan disorot otomatis di UI dan terdeteksi di fitur Cek Duplikat)
            // Biarkan proses insert berjalan untuk semua data yang tidak kosong.

            // 4. PARSING INSTANSI (Bisa baca format ekspor lama & form baru)
            $rawInstansi = $row['instansi_asal_kab'] ?? $row['asal_instansi'] ?? $row['instansi'] ?? 'Tidak Ada';
            $instansi = $rawInstansi;
            $kabupaten = $row['asal_kabupatenkota'] ?? $row['kabupaten_kota'] ?? $row['kabupaten'] ?? 'Kota Kendari';

            if (str_contains($rawInstansi, 'Kab/Kota:')) {
                $parts = explode('Kab/Kota:', $rawInstansi);
                $instansi = trim($parts[0]);
                $kabupaten = trim($parts[1] ?? 'Kota Kendari');
            }

            // 5. HELPER PENCARI KUNCI KOLOM SKM (Tahan Banting terhadap nama kolom panjang)
            $defaultSkor = 3;
            if (isset($row['skor_skm'])) {
                $defaultSkor = (int) round((float) str_replace(',', '.', $row['skor_skm']));
            }

            $konversiNilai = function ($keyword) use ($row, $defaultSkor) {
                $cleanKw = str_replace(['_', ' '], '', strtolower($keyword));
                foreach ($row as $key => $value) {
                    $cleanKey = str_replace(['_', ' '], '', strtolower((string) $key));
                    if (str_contains($cleanKey, $cleanKw) || str_contains((string) $key, $keyword)) {
                        $jawaban = strtolower(trim((string) $value));
                        if (is_numeric($value) && (int) $value >= 1 && (int) $value <= 4) {
                            return (int) $value;
                        }
                        if (str_contains($jawaban, 'sangat puas') || str_contains($jawaban, 'sangat baik')) {
                            return 4;
                        }
                        if (str_contains($jawaban, 'tidak puas') || str_contains($jawaban, 'kurang')) {
                            return 2;
                        }
                        if (str_contains($jawaban, 'sangat tidak')) {
                            return 1;
                        }

                        return 3;
                    }
                }

                return $defaultSkor; // Fallback ke skor rata-rata jika kolom tidak ditemukan
            };

            // 6. SIMPAN DATA BUKU TAMU
            $rawJk = $row['jenis_kelamin'] ?? $row['lp'] ?? 'L';
            $cleanJk = strtoupper(substr(trim((string) $rawJk), 0, 1));
            $jenisKelamin = ($cleanJk === 'P') ? 'P' : 'L';

            $guestbook = Guestbook::create([
                'nama' => Str::limit($nama, 100, ''),
                'jenis_kelamin' => $jenisKelamin,
                'usia' => (int) ($row['usia'] ?? 30),
                'telepon' => $row['nomor_teleponhpwa'] ?? $row['no_telepon'] ?? null,
                'pendidikan' => Str::limit($row['pendidikan_terakhir'] ?? $row['pendidikan'] ?? 'Lainnya', 45, ''),
                'pekerjaan' => Str::limit($row['pekerjaan'] ?? 'Lainnya', 45, ''),
                'status_kepegawaian' => Str::limit($row['status_kepegawaian'] ?? 'PNS', 30, ''),
                'asal_instansi' => Str::limit($instansi, 150, ''),
                'asal_kabupaten' => Str::limit($kabupaten, 50, ''),
                'jenis_layanan' => $row['jenis_layanan_yang_diperoleh'] ?? $row['jenis_layanan'] ?? 'Lainnya',
                'import_batch_id' => $this->batchId,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // 7. SIMPAN DATA KUISIONER
            UltSurveyResponse::create([
                'guestbook_id' => $guestbook->id,
                'q1' => $konversiNilai('kesesuaian_persyaratan'),
                'q2' => $konversiNilai('kemudahan_prosedur'),
                'q3' => $konversiNilai('kecepatan_waktu'),
                'q4' => $konversiNilai('tidak_dikenakan_biaya'),
                'q5' => $konversiNilai('kesesuaian_produk'),
                'q6' => $konversiNilai('kompetensi_petugas'),
                'q7' => $konversiNilai('sikapperilaku_petugas'),
                'q8' => $konversiNilai('kualitas_sarana'),
                'q9' => $konversiNilai('penanganan_pengaduan'),
                'saran' => $row['berikan_saran'] ?? $row['saran_masukan'] ?? $row['saran_dan_masukan'] ?? null,
            ]);

            $this->importedCount++;
        }
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }
}
