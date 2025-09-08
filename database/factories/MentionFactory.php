<?php

namespace Database\Factories;

use App\Models\{
    Post,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mention>
 */
class MentionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'mentioned_user_id' => User::factory(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
