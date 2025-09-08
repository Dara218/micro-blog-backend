<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageMedia>
 */
class MessageMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isVideo = fake()->boolean(30); // 30% chance of being video

        return [
            'message_id' => Message::factory(),
            'url' => $isVideo ? fake()->url() : fake()->imageUrl(800, 600),
            'mime_type' => $isVideo ? 'video/mp4' : 'image/jpeg',
            'width' => fake()->numberBetween(400, 1920),
            'height' => fake()->numberBetween(300, 1080),
            'duration_seconds' => $isVideo ? fake()->numberBetween(10, 300) : null,
        ];
    }

    /**
     * Create an image media.
     *
     * @return static
     */
    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'url' => fake()->imageUrl(800, 600),
            'mime_type' => fake()->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']),
            'duration_seconds' => null,
        ]);
    }

    /**
     * Create a video media.
     *
     * @return static
     */
    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'url' => fake()->url(),
            'mime_type' => fake()->randomElement(['video/mp4', 'video/webm', 'video/quicktime']),
            'duration_seconds' => fake()->numberBetween(10, 300),
        ]);
    }
}
