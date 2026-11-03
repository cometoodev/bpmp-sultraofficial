<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Webinar Nasional: Transformasi Pembelajaran Berbasis Rapor Pendidikan 2026',
                'type' => 'Webinar',
                'event_date' => Carbon::now()->addDays(7)->setTime(9, 0),
                'organizer' => 'BPMP Provinsi Sulawesi Tenggara',
                'image' => null,
                'instagram_url' => 'https://www.instagram.com/bpmpsultra/',
            ],
            [
                'title' => 'Gelar Karya Praktik Baik & Temu Inovasi Guru Penggerak Sulawesi Tenggara',
                'type' => 'Event',
                'event_date' => Carbon::now()->addDays(14)->setTime(8, 30),
                'organizer' => 'Kemendikdasmen & BPMP Sultra',
                'image' => null,
                'instagram_url' => 'https://www.instagram.com/bpmpsultra/',
            ],
            [
                'title' => 'Bimbingan Teknis Penguatan Tata Kelola Dana BOSP & Perencanaan Anggaran Sekolah',
                'type' => 'Webinar',
                'event_date' => Carbon::now()->subDays(3)->setTime(13, 0),
                'organizer' => 'Pokja Tata Kelola & Kemitraan BPMP Sultra',
                'image' => null,
                'instagram_url' => 'https://www.instagram.com/bpmpsultra/',
            ],
        ];

        foreach ($events as $data) {
            Event::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
