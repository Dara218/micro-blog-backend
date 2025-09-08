<?php

namespace Database\Factories;

use App\Models\{
    Comment,
    Post,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $likeableType = fake()->randomElement(['post', 'comment']);

        return [
            'user_id' => User::factory(),
            'likeable_id' => $likeableType === 'post' ? Post::factory() : Comment::factory(),
            'likeable_type' => $likeableType,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Create a like for a post.
     *
     * @param Post|null $post The post to like, or null to generate a random one
     *
     * @return static
     */
    public function forPost(?Post $post = null): static
    {
        return $this->state(fn (array $attributes) => [
            'likeable_id' => $post?->id ?? Post::factory(),
            'likeable_type' => 'post',
        ]);
    }

    /**
     * Create a like for a comment.
     *
     * @param Comment|null $comment The comment to like, or null to generate a random one
     *
     * @return static
     */
    public function forComment(?Comment $comment = null): static
    {
        return $this->state(fn (array $attributes) => [
            'likeable_id' => $comment?->id ?? Comment::factory(),
            'likeable_type' => 'comment',
        ]);
    }
}
