<?php

namespace Tests\Feature\Api;

use App\Models\Guestbook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicServicesApiTest extends TestCase
{
    use RefreshDatabase;

    // ==========================================
    // 1. SKM (SURVEY KEPUASAN MASYARAKAT)
    // ==========================================

    public function test_can_get_skm_questions_and_scales(): void
    {
        $response = $this->getJson('/api/skm/questions');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'rating_scales',
                    'questions' => [
                        '*' => ['key', 'number', 'title', 'description'],
                    ],
                ],
            ]);
    }

    public function test_can_submit_skm_survey_response(): void
    {
        $guestbook = Guestbook::factory()->create();

        $payload = [
            'guestbook_id' => $guestbook->id,
            'q1' => 4,
            'q2' => 4,
            'q3' => 3,
            'q4' => 4,
            'q5' => 4,
            'q6' => 4,
            'q7' => 4,
            'q8' => 3,
            'q9' => 4,
            'saran' => 'Pelayanan sangat ramah dan memuaskan.',
        ];

        $response = $this->postJson('/api/skm', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'guestbook_id' => $guestbook->id,
                    'answers' => [
                        'q1' => 4,
                        'q9' => 4,
                    ],
                ],
            ]);

        $this->assertDatabaseHas('ult_survey_responses', [
            'guestbook_id' => $guestbook->id,
            'q1' => 4,
            'saran' => 'Pelayanan sangat ramah dan memuaskan.',
        ]);
    }

    public function test_validates_skm_scores_must_be_between_1_and_4(): void
    {
        $guestbook = Guestbook::factory()->create();

        $response = $this->postJson('/api/skm', [
            'guestbook_id' => $guestbook->id,
            'q1' => 5, // Invalid: max 4
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['q1', 'q2']);
    }

    // ==========================================
    // 2. ULT (UNIT LAYANAN TERPADU)
    // ==========================================

    public function test_can_get_ult_options(): void
    {
        $response = $this->getJson('/api/ult/options');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => ['layanan_types', 'kategori', 'statuses'],
            ]);
    }

    public function test_can_submit_ult_request_and_generates_ticket(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('surat-permohonan.pdf', 500, 'application/pdf');

        $payload = [
            'layanan_type' => 'online',
            'nama' => 'Hasriani, S.Pd',
            'email' => 'hasriani@gmail.com',
            'no_hp' => '085299998888',
            'profesi' => 'Guru',
            'instansi' => 'SMPN 1 Kendari',
            'kategori' => 'Konsultasi Kurikulum Merdeka & Pembelajaran',
            'keperluan' => 'Permohonan advokasi penerapan kurikulum merdeka pada kelas 7.',
            'dokumen' => $file,
        ];

        $response = $this->postJson('/api/ult/requests', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'nama' => 'Hasriani, S.Pd',
                    'email' => 'hasriani@gmail.com',
                    'status' => 'pending',
                ],
            ]);

        $ticket = $response->json('ticket_number');
        $this->assertNotNull($ticket);
        $this->assertDatabaseHas('ult_requests', [
            'ticket_number' => $ticket,
            'nama' => 'Hasriani, S.Pd',
        ]);

        // Cek tracking endpoint
        $trackResponse = $this->getJson("/api/ult/track/{$ticket}");
        $trackResponse->assertStatus(200)
            ->assertJsonPath('data.ticket_number', $ticket)
            ->assertJsonPath('data.status', 'pending');
    }

    // ==========================================
    // 3. SPMB (LAYANAN PENGADUAN SPMB)
    // ==========================================

    public function test_can_get_spmb_options(): void
    {
        $response = $this->getJson('/api/spmb/options');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => ['categories', 'statuses'],
            ]);
    }

    public function test_can_submit_spmb_report(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('bukti.png');

        $payload = [
            'category' => 'zonasi',
            'name' => 'Bambang Sudarsono',
            'email' => 'bambang@gmail.com',
            'phone' => '081344556677',
            'address' => 'Jl. Pattimura No. 10 Kota Kendari',
            'message' => 'Terdapat indikasi kecurangan jarak tempat tinggal pada jalur zonasi.',
            'evidence_file' => $file,
        ];

        $response = $this->postJson('/api/spmb/reports', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'name' => 'Bambang Sudarsono',
                    'category' => 'zonasi',
                    'status' => 'pending',
                ],
            ]);

        $this->assertDatabaseHas('spmb_reports', [
            'name' => 'Bambang Sudarsono',
            'category' => 'zonasi',
        ]);
    }

    // ==========================================
    // 4. HUBUNGI KAMI / CONTACT MESSAGES
    // ==========================================

    public function test_can_get_contact_info(): void
    {
        $response = $this->getJson('/api/contacts/info');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'institution',
                    'phone',
                    'whatsapp',
                    'email',
                    'address',
                    'operating_hours',
                    'social_media',
                ],
            ]);
    }

    public function test_can_submit_contact_message(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Sri Wahyuni',
            'email' => 'sri.wahyuni@gmail.com',
            'subject' => 'Informasi Pelatihan Guru Penggerak',
            'message' => 'Mohon informasi jadwal pelatihan guru penggerak angkatan berikutnya.',
        ];

        $response = $this->postJson('/api/contacts', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'name' => 'Sri Wahyuni',
                    'subject' => 'Informasi Pelatihan Guru Penggerak',
                ],
            ]);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Sri Wahyuni',
            'email' => 'sri.wahyuni@gmail.com',
        ]);
    }
}
