<?php

namespace Database\Factories;

use App\Models\{
    Conversation,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'user_id' => User::factory(),
            'body' => fake()->optional(0.8)->paragraph(), // 80% chance of having text
        ];
    }

    /**
     * Create a text message.
     *
     * @return static
     */
    public function text(): static
    {
        return $this->state(fn (array $attributes) => [
            'body' => fake()->paragraph(),
        ]);
    }

    /**
     * Create a media-only message.
     *
     * @return static
     */
    public function mediaOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'body' => null,
        ]);
    }
}
