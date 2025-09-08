<?php

namespace Database\Factories;

use App\Models\{
    Post,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Share>
 */
class ShareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'quote_text' => fake()->optional(0.3)->paragraph(),
        ];
    }

    /**
     * Create a share with quote text.
     *
     * @return static
     */
    public function withQuote(): static
    {
        return $this->state(fn (array $attributes) => [
            'quote_text' => fake()->paragraph(),
        ]);
    }

    /**
     * Create a share without quote text.
     *
     * @return static
     */
    public function withoutQuote(): static
    {
        return $this->state(fn (array $attributes) => [
            'quote_text' => null,
        ]);
    }
}
