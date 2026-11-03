<?php

namespace Tests\Unit;

use App\Models\SpmbReport;
use Tests\TestCase;

class SpmbReportModelTest extends TestCase
{
    public function test_spmb_report_fillable_attributes(): void
    {
        $report = new SpmbReport([
            'category' => 'spmb',
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Pendidikan No. 1, Kendari',
            'message' => 'Layanan informasi sangat membantu.',
            'evidence_file' => 'spmb-evidences/sample.jpg',
            'status' => 'pending',
        ]);

        $this->assertEquals('spmb', $report->category);
        $this->assertEquals('Budi Santoso', $report->name);
        $this->assertEquals('budi@example.com', $report->email);
        $this->assertEquals('08123456789', $report->phone);
        $this->assertEquals('Jl. Pendidikan No. 1, Kendari', $report->address);
        $this->assertEquals('Layanan informasi sangat membantu.', $report->message);
        $this->assertEquals('spmb-evidences/sample.jpg', $report->evidence_file);
        $this->assertEquals('pending', $report->status);
        $this->assertStringContainsString('storage/spmb-evidences/sample.jpg', $report->evidence_url);
    }
}
