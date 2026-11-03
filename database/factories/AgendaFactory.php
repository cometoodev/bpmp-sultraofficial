<?php

namespace Database\Factories;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agenda>
 */
class AgendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'agenda_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'time_start' => '08.00',
            'time_end' => '16.00',
            'description' => fake()->paragraph(),
        ];
    }
}
