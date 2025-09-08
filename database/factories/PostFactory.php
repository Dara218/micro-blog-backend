<?php

namespace Database\Factories;

use App\Enums\{
    CommentsAllowFlag,
    PostVisibility,
    SharesAllowFlag
};
use App\Models\{
    Post,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'content' => fake()->paragraphs(rand(1, 3), true),
            'visibility' => fake()->randomElement(PostVisibility::cases())->value,
            'is_comments_allowed' => fake()->randomElement(CommentsAllowFlag::cases())->value,
            'is_shares_allowed' => fake()->randomElement(SharesAllowFlag::cases())->value,
            'reply_to_post_id' => null,
            'like_count' => fake()->numberBetween(0, 1000),
            'comment_count' => fake()->numberBetween(0, 100),
            'share_count' => fake()->numberBetween(0, 50),
        ];
    }

    /**
     * Create a reply post.
     *
     * @param Post $parentPost The parent post to reply to
     * @return static
     */
    public function reply(Post $parentPost): static
    {
        return $this->state(fn (array $attributes) => [
            'reply_to_post_id' => $parentPost->id,
        ]);
    }

    /**
     * Create a public post.
     *
     * @return static
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => PostVisibility::PUBLIC->value,
        ]);
    }

    /**
     * Create a followers-only post.
     *
     * @return static
     */
    public function followers(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => PostVisibility::FOLLOWERS->value,
        ]);
    }

    /**
     * Create a private post.
     *
     * @return static
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => PostVisibility::PRIVATE->value,
        ]);
    }
}
