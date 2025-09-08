<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\{
    Conversation,
    Message,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConversationParticipant>
 */
class ConversationParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'user_id' => User::factory(),
            'role' => fake()->randomElement(Role::cases())->value,
            'last_read_message_id' => null,
        ];
    }

    /**
     * Create a member participant.
     *
     * @return static
     */
    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::MEMBER->value,
        ]);
    }

    /**
     * Create an admin participant.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::ADMIN->value,
        ]);
    }

    /**
     * Create a participant with last read message.
     *
     * @param Message|null $message The last read message, or null to generate a random one
     *
     * @return static
     */
    public function withLastReadMessage(?Message $message = null): static
    {
        return $this->state(fn (array $attributes) => [
            'last_read_message_id' => $message?->id ?? Message::factory(),
        ]);
    }
}
