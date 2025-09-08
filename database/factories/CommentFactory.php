<?php

namespace Database\Factories;

use App\Models\{
    Comment,
    Post,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'user_id' => User::factory(),
            'parent_comment_id' => null,
            'content' => fake()->paragraphs(rand(1, 2), true),
            'like_count' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Create a reply comment.
     *
     * @param Comment $parentComment The parent comment to reply to
     *
     * @return static
     */
    public function reply(Comment $parentComment): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_comment_id' => $parentComment->id,
            'post_id' => $parentComment->post_id,
        ]);
    }

    /**
     * Create a top-level comment.
     *
     * @return static
     */
    public function topLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_comment_id' => null,
        ]);
    }
}
