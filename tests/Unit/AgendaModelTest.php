<?php

namespace Tests\Unit;

use App\Models\Agenda;
use Carbon\Carbon;
use Tests\TestCase;

class AgendaModelTest extends TestCase
{
    public function test_agenda_fillable_attributes(): void
    {
        $agenda = new Agenda([
            'title' => 'Rapat Koordinasi Prioritas Pendidikan',
            'agenda_date' => '2026-11-15',
            'time_start' => '08.30',
            'time_end' => '12.00',
            'description' => 'Gedung Aula BPMP Sultra',
        ]);

        $this->assertEquals('Rapat Koordinasi Prioritas Pendidikan', $agenda->title);
        $this->assertEquals('08.30', $agenda->time_start);
        $this->assertEquals('12.00', $agenda->time_end);
        $this->assertEquals('Gedung Aula BPMP Sultra', $agenda->description);
        $this->assertInstanceOf(Carbon::class, $agenda->agenda_date);
        $this->assertEquals('2026-11-15', $agenda->agenda_date->format('Y-m-d'));
    }

    public function test_agenda_casts_agenda_date_to_date(): void
    {
        $agenda = new Agenda(['agenda_date' => '2026-12-05']);

        $this->assertInstanceOf(Carbon::class, $agenda->agenda_date);
        $this->assertEquals(5, $agenda->agenda_date->day);
        $this->assertEquals(12, $agenda->agenda_date->month);
        $this->assertEquals(2026, $agenda->agenda_date->year);
    }
}
