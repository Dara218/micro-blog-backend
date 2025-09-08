<?php

namespace Database\Factories;

use App\Enums\MediaType;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostMedia>
 */
class PostMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mediaType = fake()->randomElement(MediaType::cases());
        $isVideo = $mediaType === MediaType::VIDEO;

        return [
            'post_id' => Post::factory(),
            'type' => $mediaType->value,
            'url' => fake()->imageUrl(800, 600),
            'mime_type' => $isVideo ? 'video/mp4' : 'image/jpeg',
            'width' => fake()->numberBetween(400, 1920),
            'height' => fake()->numberBetween(300, 1080),
            'duration_seconds' => $isVideo ? fake()->numberBetween(10, 300) : null,
            'sort_order' => fake()->numberBetween(0, 5),
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
            'type' => MediaType::IMAGE->value,
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
            'type' => MediaType::VIDEO->value,
            'mime_type' => fake()->randomElement(['video/mp4', 'video/webm', 'video/quicktime']),
            'duration_seconds' => fake()->numberBetween(10, 300),
        ]);
    }
}
