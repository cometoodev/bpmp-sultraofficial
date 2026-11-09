<?php

namespace Database\Factories;

use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UltSurveyResponse>
 */
class UltSurveyResponseFactory extends Factory
{
    protected $model = UltSurveyResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'guestbook_id' => Guestbook::factory(),
            'q1' => fake()->numberBetween(1, 4),
            'q2' => fake()->numberBetween(1, 4),
            'q3' => fake()->numberBetween(1, 4),
            'q4' => fake()->numberBetween(1, 4),
            'q5' => fake()->numberBetween(1, 4),
            'q6' => fake()->numberBetween(1, 4),
            'q7' => fake()->numberBetween(1, 4),
            'q8' => fake()->numberBetween(1, 4),
            'q9' => fake()->numberBetween(1, 4),
            'saran' => fake()->sentence(),
        ];
    }
}
