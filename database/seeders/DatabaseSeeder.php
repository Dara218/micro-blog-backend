<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core entities first
            UserSeeder::class,
            HashtagSeeder::class,

            // Content entities
            PostSeeder::class,
            PostMediaSeeder::class,
            CommentSeeder::class,

            // Social interactions
            LikeSeeder::class,
            ShareSeeder::class,
            BookmarkSeeder::class,
            FollowSeeder::class,
            UserBlockSeeder::class,
            MentionSeeder::class,

            // Content relationships
            PostHashtagSeeder::class,

            // Messaging system
            ConversationSeeder::class,
            ConversationParticipantSeeder::class,
            MessageSeeder::class,
            MessageMediaSeeder::class,

            // System entities
            NotificationSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
