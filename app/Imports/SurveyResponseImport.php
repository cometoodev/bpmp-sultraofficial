<?php

namespace App\Imports;

use App\Models\SurveyResponse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SurveyResponseImport implements ToCollection, WithHeadingRow
{
    protected int $surveyId;

    protected int $importedCount = 0;

    /**
     * @var array<int, string>
     */
    protected array $importErrors = [];

    public function __construct(int $surveyId)
    {
        $this->surveyId = $surveyId;
    }

    /**
     * @param  Collection<int, mixed>  $rows
     */
    public function collection(Collection $rows): void
    {
        $insertData = [];

        foreach ($rows as $index => $row) {
            $rowArray = $row instanceof Collection ? $row->toArray() : (array) $row;

            // Cari kolom unsur U1..U9 (case-insensitive & toleran variasi)
            $uValues = [];
            $allUnsurValid = true;

            for ($i = 1; $i <= 9; $i++) {
                $val = $this->extractUnsurValue($rowArray, $i);

                if ($val === null || $val < 1 || $val > 4) {
                    $allUnsurValid = false;
                    break;
                }

                $uValues['u'.$i] = (int) $val;
            }

            // Jika baris kosong (misal baris kosong di bawah file excel), lewati
            if (! $allUnsurValid && $this->isRowEmpty($rowArray)) {
                continue;
            }

            if (! $allUnsurValid) {
                $rowNumber = $index + 2; // +2 karena heading row di baris 1
                $this->importErrors[] = "Baris #{$rowNumber}: Nilai unsur (U1 - U9) harus bernilai angka antara 1 sampai 4.";

                continue;
            }

            $name = $this->extractField($rowArray, ['nama', 'nama_responden', 'name', 'responden']);
            $age = $this->extractField($rowArray, ['usia', 'umur', 'age']);
            $job = $this->extractField($rowArray, ['pekerjaan', 'profesi', 'job', 'occupation']);

            $insertData[] = array_merge([
                'survey_id' => $this->surveyId,
                'respondent_name' => $name ? trim((string) $name) : null,
                'respondent_age' => is_numeric($age) ? (int) $age : null,
                'respondent_job' => $job ? trim((string) $job) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ], $uValues);
        }

        if (! empty($insertData)) {
            // Bulk insert per chunk 500 rows
            foreach (array_chunk($insertData, 500) as $chunk) {
                SurveyResponse::insert($chunk);
            }
            $this->importedCount = count($insertData);
        }
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * @return array<int, string>
     */
    public function getImportErrors(): array
    {
        return $this->importErrors;
    }

    /**
     * @param  array<string, mixed>  $row
     */
    protected function extractUnsurValue(array $row, int $unsurIndex): ?int
    {
        $keysToTry = [
            'u'.$unsurIndex,
            'u_'.$unsurIndex,
            'unsur_'.$unsurIndex,
            'unsur'.$unsurIndex,
            'pertanyaan_'.$unsurIndex,
            'p'.$unsurIndex,
        ];

        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(trim(str_replace([' ', '-', '_'], '', (string) $key)));
            foreach ($keysToTry as $candidate) {
                $normalizedCandidate = strtolower(trim(str_replace([' ', '-', '_'], '', $candidate)));
                if ($normalizedKey === $normalizedCandidate && is_numeric($value)) {
                    return (int) $value;
                }
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $row
     * @param  array<int, string>  $aliases
     */
    protected function extractField(array $row, array $aliases): mixed
    {
        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(trim(str_replace([' ', '-', '_'], '', (string) $key)));
            foreach ($aliases as $alias) {
                $normalizedAlias = strtolower(trim(str_replace([' ', '-', '_'], '', $alias)));
                if ($normalizedKey === $normalizedAlias && $value !== null && $value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $row
     */
    protected function isRowEmpty(array $row): bool
    {
        foreach ($row as $val) {
            if ($val !== null && trim((string) $val) !== '') {
                return false;
            }
        }

        return true;
    }
}
