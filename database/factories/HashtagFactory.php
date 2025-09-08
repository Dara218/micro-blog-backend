<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hashtag>
 */
class HashtagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = '#' . fake()->unique()->word();

        return [
            'name' => $name,
            'usage_count' => fake()->numberBetween(0, 1000),
        ];
    }

    /**
     * Create a popular hashtag.
     *
     * @return static
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => fake()->numberBetween(500, 10000),
        ]);
    }

    /**
     * Create a trending hashtag.
     *
     * @return static
     */
    public function trending(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => fake()->numberBetween(1000, 50000),
        ]);
    }
}
