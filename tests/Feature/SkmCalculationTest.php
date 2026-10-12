<?php

namespace Tests\Feature;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use App\Services\SkmCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SkmCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_skm_calculation_service_calculates_correctly_according_to_permenpan_rb_14_2017(): void
    {
        $survey = Survey::create([
            'title' => 'Survei Kepuasan Uji Coba',
            'period' => 'Triwulan 1',
            'year' => 2026,
            'is_active' => true,
        ]);

        // Responden 1 (semua 4)
        SurveyResponse::create([
            'survey_id' => $survey->id,
            'respondent_name' => 'Responden A',
            'u1' => 4, 'u2' => 4, 'u3' => 4, 'u4' => 4, 'u5' => 4,
            'u6' => 4, 'u7' => 4, 'u8' => 4, 'u9' => 4,
        ]);

        // Responden 2 (semua 3)
        SurveyResponse::create([
            'survey_id' => $survey->id,
            'respondent_name' => 'Responden B',
            'u1' => 3, 'u2' => 3, 'u3' => 3, 'u4' => 3, 'u5' => 3,
            'u6' => 3, 'u7' => 3, 'u8' => 3, 'u9' => 3,
        ]);

        // N = 2
        // Rata-rata per unsur = (4 + 3) / 2 = 3.5
        // NRT per unsur = 3.5 * 0.111 = 0.3885
        // Total NRT 9 unsur = 9 * 0.3885 = 3.4965
        // Nilai SKM = 3.4965 * 25 = 87.4125 -> dibulatkan 87.41 (Mutu B - Baik)

        $service = new SkmCalculationService;
        $updatedSurvey = $service->recalculateAndSave($survey);

        $this->assertEquals(2, $updatedSurvey->total_respondents);
        $this->assertEquals(3.5, $updatedSurvey->nrr_elements['u1']);
        $this->assertEquals(0.3885, $updatedSurvey->nrt_elements['u1']);
        $this->assertEquals(87.41, $updatedSurvey->ikm_score);
        $this->assertEquals('B', $updatedSurvey->ikm_service_quality);
        $this->assertEquals('Baik', $updatedSurvey->ikm_performance_category);
    }

    public function test_survey_can_be_viewed_with_calculated_details_in_admin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $survey = Survey::create([
            'title' => 'Survei Kepuasan Masyarakat 2026',
            'period' => 'Triwulan 1',
            'year' => 2026,
            'total_respondents' => 150,
            'nrr_elements' => [
                'u1' => 3.65, 'u2' => 3.50, 'u3' => 3.40, 'u4' => 3.90, 'u5' => 3.70,
                'u6' => 3.80, 'u7' => 3.60, 'u8' => 3.75, 'u9' => 3.60,
            ],
            'nrt_elements' => [
                'u1' => 0.4052, 'u2' => 0.3885, 'u3' => 0.3774, 'u4' => 0.4329, 'u5' => 0.4107,
                'u6' => 0.4218, 'u7' => 0.3996, 'u8' => 0.4163, 'u9' => 0.3996,
            ],
            'ikm_score' => 91.30,
            'ikm_service_quality' => 'A',
            'ikm_performance_category' => 'Sangat Baik',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.surveys.show', $survey));

        $response->assertStatus(200);
        $response->assertSee('91,30');
        $response->assertSee('SANGAT BAIK');
        $response->assertSee('MUTU A');
        $response->assertSee('Triwulan 1');
    }

    public function test_admin_can_import_csv_or_excel_file_and_calculate_skm(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $csvHeader = "Nama,Usia,Pekerjaan,U1,U2,U3,U4,U5,U6,U7,U8,U9\n";
        $csvRow1 = "Budi,30,Guru,4,4,4,4,4,4,4,4,4\n";
        $csvRow2 = "Siti,25,PNS,4,4,4,4,4,4,4,4,4\n";
        $csvContent = $csvHeader.$csvRow1.$csvRow2;

        $tempFile = tempnam(sys_get_temp_dir(), 'skm').'.csv';
        file_put_contents($tempFile, $csvContent);

        $uploadedFile = new UploadedFile(
            $tempFile,
            'kuesioner.csv',
            'text/csv',
            null,
            true
        );

        $response = $this->actingAs($admin)->post(route('admin.surveys.store'), [
            'title' => 'Survei BPMP 2026 Triwulan 1',
            'period' => 'Triwulan 1',
            'year' => 2026,
            'description' => 'Uji Coba Import CSV/Excel',
            'is_active' => true,
            'file' => $uploadedFile,
        ]);

        $response->assertRedirect();

        $survey = Survey::where('title', 'Survei BPMP 2026 Triwulan 1')->first();
        $this->assertNotNull($survey);
        $this->assertEquals(2, $survey->total_respondents);
        $this->assertEquals(4.0, $survey->nrr_elements['u1']);
        $this->assertEquals(99.9, $survey->ikm_score); // 9 * (4 * 0.111) * 25 = 9 * 0.444 * 25 = 99.9
        $this->assertEquals('A', $survey->ikm_service_quality);
        $this->assertEquals('Sangat Baik', $survey->ikm_performance_category);
        $this->assertTrue($survey->is_active);

        $this->assertDatabaseHas('survey_responses', [
            'survey_id' => $survey->id,
            'respondent_name' => 'Budi',
            'u1' => 4,
        ]);

        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
    }

    public function test_welcome_page_displays_active_survey_values(): void
    {
        Survey::create([
            'title' => 'Survei Kepuasan Masyarakat 2026',
            'period' => 'Triwulan 1',
            'year' => 2026,
            'total_respondents' => 150,
            'nrr_elements' => [
                'u1' => 3.65, 'u2' => 3.50, 'u3' => 3.40, 'u4' => 3.90, 'u5' => 3.70,
                'u6' => 3.80, 'u7' => 3.60, 'u8' => 3.75, 'u9' => 3.60,
            ],
            'nrt_elements' => [
                'u1' => 0.4052, 'u2' => 0.3885, 'u3' => 0.3774, 'u4' => 0.4329, 'u5' => 0.4107,
                'u6' => 0.4218, 'u7' => 0.3996, 'u8' => 0.4163, 'u9' => 0.3996,
            ],
            'ikm_score' => 91.30,
            'ikm_service_quality' => 'A',
            'ikm_performance_category' => 'Sangat Baik',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('91,30');
        $response->assertSee('SANGAT BAIK');
        $response->assertSee('NILAI IKM — TRIWULAN 1 TAHUN 2026');
        $response->assertSee('3.65'); // Unsur 1
        $response->assertSee('3.90'); // Unsur 4
    }

    public function test_admin_can_view_surveys_index_with_search_and_filters(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Survey::create([
            'title' => 'Survei Kepuasan Triwulan 1',
            'period' => 'Triwulan 1',
            'year' => 2026,
            'total_respondents' => 50,
            'ikm_score' => 88.50,
            'ikm_service_quality' => 'A',
            'ikm_performance_category' => 'Sangat Baik',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.surveys.index', ['q' => 'Triwulan']));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Survei Kepuasan (SKM)');
        $response->assertSee('Survei Kepuasan Triwulan 1');
        $response->assertSee('88,50');
        $response->assertSee('Tampil di Web');
    }

    public function test_admin_can_fill_survey_manually_per_triwulan(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.surveys.store'), [
            'entry_type' => 'manual',
            'title' => 'SKM Triwulan 2 Tahun 2026',
            'period' => 'Triwulan 2',
            'year' => 2026,
            'total_respondents' => 120,
            'is_active' => true,
            'u1' => 3.60,
            'u2' => 3.50,
            'u3' => 3.70,
            'u4' => 3.90,
            'u5' => 3.65,
            'u6' => 3.80,
            'u7' => 3.75,
            'u8' => 3.60,
            'u9' => 3.70,
        ]);

        $response->assertRedirect();

        $survey = Survey::where('period', 'Triwulan 2')->where('year', 2026)->first();
        $this->assertNotNull($survey);
        $this->assertEquals(120, $survey->total_respondents);
        $this->assertEquals(3.60, $survey->nrr_elements['u1']);
        $this->assertGreaterThan(85, $survey->ikm_score);
        $this->assertTrue($survey->is_active);
    }

    public function test_admin_can_update_survey_per_triwulan(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $survey = Survey::create([
            'title' => 'SKM Triwulan 3 2026',
            'period' => 'Triwulan 3',
            'year' => 2026,
            'total_respondents' => 80,
            'nrr_elements' => ['u1' => 3.0, 'u2' => 3.0, 'u3' => 3.0, 'u4' => 3.0, 'u5' => 3.0, 'u6' => 3.0, 'u7' => 3.0, 'u8' => 3.0, 'u9' => 3.0],
            'nrt_elements' => ['u1' => 0.333, 'u2' => 0.333, 'u3' => 0.333, 'u4' => 0.333, 'u5' => 0.333, 'u6' => 0.333, 'u7' => 0.333, 'u8' => 0.333, 'u9' => 0.333],
            'ikm_score' => 74.93,
            'ikm_service_quality' => 'C',
            'ikm_performance_category' => 'Kurang Baik',
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.surveys.update', $survey), [
            'title' => 'SKM Triwulan 3 2026 Diperbarui',
            'period' => 'Triwulan 3',
            'year' => 2026,
            'total_respondents' => 100,
            'is_active' => true,
            'u1' => 3.80,
            'u2' => 3.80,
            'u3' => 3.80,
            'u4' => 3.80,
            'u5' => 3.80,
            'u6' => 3.80,
            'u7' => 3.80,
            'u8' => 3.80,
            'u9' => 3.80,
        ]);

        $response->assertRedirect();

        $survey->refresh();
        $this->assertEquals('SKM Triwulan 3 2026 Diperbarui', $survey->title);
        $this->assertEquals(100, $survey->total_respondents);
        $this->assertEquals(3.80, $survey->nrr_elements['u1']);
        $this->assertEquals('A', $survey->ikm_service_quality);
        $this->assertTrue($survey->is_active);
    }
}
