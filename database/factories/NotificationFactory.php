<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            'post_liked',
            'comment_added',
            'followed_you',
            'post_shared',
            'mentioned_you',
            'comment_liked',
        ];

        $type = fake()->randomElement($types);
        $data = $this->generateNotificationData($type);

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'data' => $data,
            'read_at' => fake()->optional(0.3)->dateTimeBetween('-1 month', 'now'), // 30% chance of being read
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Generate notification data based on type.
     *
     * @param string $type The notification type
     *
     * @return array<string, mixed>
     */
    private function generateNotificationData(string $type): array
    {
        $baseData = [
            'actor_id' => fake()->numberBetween(1, 1000), // Use actual user ID range
        ];

        switch ($type) {
            case 'post_liked':
            case 'post_shared':
            case 'mentioned_you':
                $baseData['post_id'] = fake()->numberBetween(1, 1000);
                break;
            case 'comment_added':
            case 'comment_liked':
                $baseData['post_id'] = fake()->numberBetween(1, 1000);
                $baseData['comment_id'] = fake()->numberBetween(1, 5000);
                break;
            case 'followed_you':
                // No additional data needed
                break;
        }

        return $baseData;
    }

    /**
     * Create a read notification.
     *
     * @return static
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create an unread notification.
     *
     * @return static
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }
}
