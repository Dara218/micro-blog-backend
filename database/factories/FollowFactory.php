<?php

namespace Database\Factories;

use App\Enums\FollowStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'follower_id' => User::factory(),
            'followed_id' => User::factory(),
            'status' => fake()->randomElement(FollowStatus::cases())->value,
        ];
    }

    /**
     * Create an accepted follow.
     *
     * @return static
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FollowStatus::ACCEPTED->value,
        ]);
    }

    /**
     * Create a pending follow.
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FollowStatus::PENDING->value,
        ]);
    }

    /**
     * Create a blocked follow.
     *
     * @return static
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FollowStatus::BLOCKED->value,
        ]);
    }
}
