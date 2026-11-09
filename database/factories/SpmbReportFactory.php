<?php

namespace Database\Factories;

use App\Models\SpmbReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpmbReport>
 */
class SpmbReportFactory extends Factory
{
    protected $model = SpmbReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(['spmb', 'zonasi', 'afirmasi', 'pungli']),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'message' => fake()->paragraph(),
            'evidence_file' => null,
            'status' => 'pending',
            'admin_note' => null,
        ];
    }
}
