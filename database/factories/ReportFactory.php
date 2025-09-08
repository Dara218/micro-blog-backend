<?php

namespace Database\Factories;

use App\Enums\ReportStatus;
use App\Models\{
    Comment,
    Post,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reportableType = fake()->randomElement(['post', 'comment']);
        $reasons = [
            'Spam',
            'Harassment',
            'Inappropriate content',
            'Hate speech',
            'Violence',
            'Copyright violation',
            'Other',
        ];

        return [
            'reporter_id' => fake()->numberBetween(1, 1000), // Use actual user ID range
            'reportable_id' => fake()->numberBetween(1, 1000), // Use actual ID range
            'reportable_type' => $reportableType,
            'reason' => fake()->randomElement($reasons),
            'notes' => fake()->optional(0.5)->paragraph(),
            'status' => fake()->randomElement(ReportStatus::cases())->value,
        ];
    }

    /**
     * Create a report for a post.
     *
     * @param ?$post The post of the user
     *
     * @return static
     */
    public function forPost(?Post $post = null): static
    {
        return $this->state(fn (array $attributes) => [
            'reportable_id' => $post?->id ?? fake()->numberBetween(1, 1000),
            'reportable_type' => 'post',
        ]);
    }

    /**
     * Create a report for a comment.
     * 
     * @param ?$comment The comment of the post
     *
     * @return static
     */
    public function forComment(?Comment $comment = null): static
    {
        return $this->state(fn (array $attributes) => [
            'reportable_id' => $comment?->id ?? fake()->numberBetween(1, 1000),
            'reportable_type' => 'comment',
        ]);
    }

    /**
     * Create an open report.
     *
     * @return static
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReportStatus::OPEN->value,
        ]);
    }

    /**
     * Create a resolved report.
     *
     * @return static
     */
    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReportStatus::RESOLVED->value,
        ]);
    }
}
