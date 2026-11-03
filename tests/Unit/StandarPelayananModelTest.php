<?php

namespace Tests\Unit;

use App\Models\StandarPelayanan;
use Tests\TestCase;

class StandarPelayananModelTest extends TestCase
{
    public function test_standar_pelayanan_fillable_attributes(): void
    {
        $model = new StandarPelayanan([
            'title' => 'Maklumat Pelayanan',
            'file_path' => 'http://localhost/storage/standar-pelayanan/test.pdf',
            'file_size' => '1.25 MB',
            'uploaded_at' => '2026-11-01 12:00:00',
        ]);

        $this->assertEquals('Maklumat Pelayanan', $model->title);
        $this->assertEquals('http://localhost/storage/standar-pelayanan/test.pdf', $model->file_path);
        $this->assertEquals('1.25 MB', $model->file_size);
        $this->assertNotNull($model->uploaded_at);
    }
}
