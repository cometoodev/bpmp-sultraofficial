<?php

namespace Tests\Unit;

use App\Models\Event;
use Carbon\Carbon;
use Tests\TestCase;

class EventModelTest extends TestCase
{
    public function test_event_fillable_attributes(): void
    {
        $event = new Event([
            'title' => 'Webinar Transformasi Digital Pendidikan',
            'type' => 'Webinar',
            'event_date' => '2026-11-20 09:00:00',
            'organizer' => 'Tim Kerja Inovasi BPMP Sultra',
            'instagram_url' => 'https://www.instagram.com/p/DB123456789/',
        ]);

        $this->assertEquals('Webinar Transformasi Digital Pendidikan', $event->title);
        $this->assertEquals('Webinar', $event->type);
        $this->assertEquals('Tim Kerja Inovasi BPMP Sultra', $event->organizer);
        $this->assertEquals('https://www.instagram.com/p/DB123456789/', $event->instagram_url);
        $this->assertInstanceOf(Carbon::class, $event->event_date);
        $this->assertEquals('2026-11-20 09:00:00', $event->event_date->format('Y-m-d H:i:s'));
    }

    public function test_event_status_accessor_coming_soon_when_future(): void
    {
        $futureDate = Carbon::now()->addDays(7);
        $event = new Event([
            'title' => 'Upcoming Event',
            'event_date' => $futureDate,
        ]);

        $this->assertEquals('Coming Soon', $event->status);
    }

    public function test_event_status_accessor_selesai_when_past(): void
    {
        $pastDate = Carbon::now()->subDays(2);
        $event = new Event([
            'title' => 'Past Event',
            'event_date' => $pastDate,
        ]);

        $this->assertEquals('Selesai', $event->status);
    }
}
