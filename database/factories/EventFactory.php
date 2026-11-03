<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'type' => fake()->randomElement(['Webinar', 'Event']),
            'event_date' => fake()->dateTimeBetween('-1 week', '+1 month'),
            'organizer' => 'BPMP Provinsi Sulawesi Tenggara',
            'image' => null,
            'instagram_url' => 'https://www.instagram.com/p/DB123456789/',
        ];
    }
}
