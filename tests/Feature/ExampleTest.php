<?php

namespace Tests\Feature;

use App\Models\Guestbook;
use App\Models\SpmbReport;
use App\Models\StandarPelayanan;
use App\Models\UltRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test bahwa statistik kinerja dihitung otomatis dari database.
     */
    public function test_homepage_calculates_and_displays_performance_statistics(): void
    {
        StandarPelayanan::create([
            'title' => 'Standar Uji Coba 1',
            'file_path' => 'storage/test1.pdf',
            'file_size' => '1 MB',
            'uploaded_at' => now(),
        ]);
        StandarPelayanan::create([
            'title' => 'Standar Uji Coba 2',
            'file_path' => 'storage/test2.pdf',
            'file_size' => '2 MB',
            'uploaded_at' => now(),
        ]);

        SpmbReport::create([
            'category' => 'spmb',
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'address' => 'Kendari',
            'message' => 'Laporan 1',
            'status' => 'completed',
        ]);
        SpmbReport::create([
            'category' => 'spmb',
            'name' => 'Siti',
            'email' => 'siti@example.com',
            'phone' => '081234567891',
            'address' => 'Kendari',
            'message' => 'Laporan 2',
            'status' => 'pending',
        ]);

        Guestbook::factory()->create();
        UltRequest::factory()->create([
            'status' => 'selesai',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('totalDokumenStandar', 2);
        $response->assertViewHas('totalKunjunganUlt', 2);
        $response->assertViewHas('resolvedRate', 50.0);
        $response->assertSee('Statistik');
        $response->assertSee('Kinerja');
        $response->assertSee('Standar Pelayanan');
        $response->assertSee('Penyelesaian Aduan');
        $response->assertSee('Layanan ULT');
        $response->assertSee('Indeks Kepuasan SKM');
    }
}
