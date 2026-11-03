<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();

        $agendas = [
            [
                'title' => 'Rapat Koordinasi Mingguan Pimpinan & Pokja',
                'agenda_date' => $today->toDateString(),
                'time_start' => '09.00',
                'time_end' => '11.30',
                'description' => 'Koordinasi berkala evaluasi capaian program dan layanan BPMP Sultra.',
            ],
            [
                'title' => 'Webinar Implementasi Kurikulum Merdeka Jenjang Dikdas',
                'agenda_date' => $today->copy()->addDays(5)->toDateString(),
                'time_start' => '13.00',
                'time_end' => '15.30',
                'description' => 'Pendampingan implementasi kurikulum merdeka bagi para kepala sekolah dan pendidik.',
            ],
            [
                'title' => 'Pendampingan Perencanaan Berbasis Data (PBD) Daerah',
                'agenda_date' => $today->copy()->addDays(10)->toDateString(),
                'time_start' => '08.30',
                'time_end' => '16.00',
                'description' => 'Fasilitasi pemanfaatan rapor pendidikan untuk penyusunan RKT dan RKAS.',
            ],
            [
                'title' => 'Monitoring dan Evaluasi Penyaluran BOSP Daerah',
                'agenda_date' => $today->copy()->addDays(15)->toDateString(),
                'time_start' => '08.00',
                'time_end' => '12.00',
                'description' => 'Pemantauan akuntabilitas dan percepatan serapan dana BOSP di kabupaten/kota sasaran.',
            ],
            [
                'title' => 'Evaluasi SAKIP Internal Tahap II BPMP Sultra',
                'agenda_date' => $today->copy()->addDays(20)->toDateString(),
                'time_start' => '09.00',
                'time_end' => '15.00',
                'description' => 'Review berkala implementasi akuntabilitas kinerja instansi pemerintah internal.',
            ],
        ];

        foreach ($agendas as $data) {
            Agenda::firstOrCreate(
                ['title' => $data['title'], 'agenda_date' => $data['agenda_date']],
                $data
            );
        }
    }
}
