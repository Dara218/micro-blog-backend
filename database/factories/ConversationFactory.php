<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_group' => fake()->boolean(20), // 20% chance of being a group
        ];
    }

    /**
     * Create a direct message conversation.
     *
     * @return static
     */
    public function direct(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_group' => false,
        ]);
    }

    /**
     * Create a group conversation.
     *
     * @return static
     */
    public function group(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_group' => true,
        ]);
    }
}
