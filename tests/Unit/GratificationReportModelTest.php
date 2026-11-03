<?php

namespace Tests\Unit;

use App\Models\GratificationReport;
use Tests\TestCase;

class GratificationReportModelTest extends TestCase
{
    public function test_gratification_report_fillable_and_accessors(): void
    {
        $report = new GratificationReport([
            'email' => 'pegawai@kemdikbud.go.id',
            'name' => 'Siti Rahmawati, S.Pd.',
            'nip' => '198501012010012001',
            'position' => 'Widyaprada Ahli Muda',
            'activity_name' => 'Pendampingan Kurikulum Merdeka',
            'activity_date' => '2026-11-01',
            'activity_location' => 'Kabupaten Kolaka',
            'free_services' => json_encode(['Transportasi', 'Penginapan']),
            'service_date' => '2026-11-01',
            'service_provider_name' => 'Dinas Pendidikan Kolaka',
            'service_provider_position' => 'Kasi Kurikulum',
            'gift_consumable_types' => json_encode(['Kue Basah', 'Buah']),
            'gift_non_consumable_desc' => 'Plakat kenang-kenangan',
            'gift_giver_name' => 'Kepala Dinas',
            'gift_giver_position' => 'Kadis Pendidikan Kolaka',
            'gift_received_date' => '2026-11-01',
            'follow_up_action' => 'Dibagikan pegawai',
            'evidence_file' => 'gratification-evidences/sample.jpg',
            'status' => 'pending',
        ]);

        $this->assertEquals('Siti Rahmawati, S.Pd.', $report->name);
        $this->assertEquals('198501012010012001', $report->nip);
        $this->assertEquals(['Transportasi', 'Penginapan'], $report->free_services_array);
        $this->assertEquals(['Kue Basah', 'Buah'], $report->gift_consumable_types_array);
        $this->assertEquals('pending', $report->status);
        $this->assertStringContainsString('storage/gratification-evidences/sample.jpg', $report->evidence_url);
    }
}
