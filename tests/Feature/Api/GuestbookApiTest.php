<?php

namespace Tests\Feature\Api;

use App\Models\Guestbook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestbookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_guestbook_list(): void
    {
        Guestbook::factory()->count(3)->create();

        $response = $this->getJson('/api/guestbooks');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                        'nama',
                        'jenis_kelamin',
                        'jenis_kelamin_label',
                        'usia',
                        'telepon',
                        'pendidikan',
                        'pekerjaan',
                        'status_kepegawaian',
                        'asal_instansi',
                        'asal_kabupaten',
                        'jenis_layanan',
                        'created_at',
                        'created_at_human',
                    ],
                ],
                'pagination' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'has_more_pages',
                ],
            ]);
    }

    public function test_can_filter_guestbook_list_by_search_query(): void
    {
        Guestbook::factory()->create([
            'nama' => 'Budi Santoso',
            'asal_instansi' => 'SMAN 1 Kendari',
        ]);

        Guestbook::factory()->create([
            'nama' => 'Siti Aminah',
            'asal_instansi' => 'SMPN 2 Baubau',
        ]);

        $response = $this->getJson('/api/guestbooks?search=Budi');

        $response->assertStatus(200)
            ->assertJsonPath('pagination.total', 1)
            ->assertJsonPath('data.0.nama', 'Budi Santoso');
    }

    public function test_can_store_new_guestbook_entry_with_valid_data(): void
    {
        $payload = [
            'nama' => 'Drs. H. Ahmad Fauzi, M.Pd',
            'jenis_kelamin' => 'L',
            'usia' => 45,
            'telepon' => '081234567890',
            'pendidikan' => 'Magister (S2)',
            'pekerjaan' => 'Kepala Sekolah',
            'status_kepegawaian' => 'PNS',
            'asal_instansi' => 'SMAN 1 Konawe',
            'asal_kabupaten' => 'Kab. Konawe',
            'jenis_layanan' => 'Konsultasi & Advokasi Program Prioritas Kemendikdasmen',
        ];

        $response = $this->postJson('/api/guestbooks', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Data kunjungan buku tamu berhasil dicatat.',
                'data' => [
                    'nama' => 'Drs. H. Ahmad Fauzi, M.Pd',
                    'jenis_kelamin' => 'L',
                    'jenis_kelamin_label' => 'Laki-laki',
                    'usia' => 45,
                    'asal_instansi' => 'SMAN 1 Konawe',
                ],
            ]);

        $this->assertDatabaseHas('guestbooks', [
            'nama' => 'Drs. H. Ahmad Fauzi, M.Pd',
            'telepon' => '081234567890',
            'asal_kabupaten' => 'Kab. Konawe',
        ]);
    }

    public function test_validates_required_fields_when_storing_guestbook(): void
    {
        $response = $this->postJson('/api/guestbooks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'nama',
                'jenis_kelamin',
                'usia',
                'pendidikan',
                'pekerjaan',
                'status_kepegawaian',
                'asal_instansi',
                'asal_kabupaten',
                'jenis_layanan',
            ]);
    }

    public function test_validates_jenis_kelamin_must_be_l_or_p(): void
    {
        $response = $this->postJson('/api/guestbooks', [
            'nama' => 'Testing User',
            'jenis_kelamin' => 'X', // Invalid
            'usia' => 30,
            'pendidikan' => 'Sarjana (S1 / D4)',
            'pekerjaan' => 'Guru / Pendidik',
            'status_kepegawaian' => 'PNS',
            'asal_instansi' => 'Dinas Pendidikan',
            'asal_kabupaten' => 'Kota Kendari',
            'jenis_layanan' => 'Layanan Data Pokok Pendidikan (Dapodik) & PDM',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['jenis_kelamin']);
    }

    public function test_can_view_single_guestbook_detail(): void
    {
        $guestbook = Guestbook::factory()->create([
            'nama' => 'Nurul Hidayah',
            'jenis_kelamin' => 'P',
        ]);

        $response = $this->getJson("/api/guestbooks/{$guestbook->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $guestbook->id,
                    'nama' => 'Nurul Hidayah',
                    'jenis_kelamin' => 'P',
                    'jenis_kelamin_label' => 'Perempuan',
                ],
            ]);
    }

    public function test_can_get_form_options_for_react_native_pickers(): void
    {
        $response = $this->getJson('/api/guestbooks/options');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'jenis_kelamin',
                    'pendidikan',
                    'status_kepegawaian',
                    'pekerjaan',
                    'asal_kabupaten',
                    'jenis_layanan',
                ],
            ]);
    }

    public function test_v1_routes_work_identical(): void
    {
        Guestbook::factory()->create(['nama' => 'V1 Tester']);

        $this->getJson('/api/v1/guestbooks')
            ->assertStatus(200)
            ->assertJsonPath('data.0.nama', 'V1 Tester');

        $this->getJson('/api/v1/guestbooks/options')
            ->assertStatus(200);
    }
}
