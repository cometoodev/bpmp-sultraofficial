<?php

namespace Database\Factories;

use App\Models\Award;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Award>
 */
class AwardFactory extends Factory
{
    protected $model = Award::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'badge' => fake()->randomElement(['Penghargaan Kemendikdasmen', 'Penghargaan Kemenkeu', 'Penghargaan DJKN', 'Maklumat Resmi']),
            'description' => fake()->paragraph(),
            'image' => null,
            'order' => fake()->numberBetween(0, 10),
        ];
    }
}
