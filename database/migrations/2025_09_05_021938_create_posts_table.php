<?php

use App\Enums\CommentsAllowFlag;
use App\Enums\PostVisibility;
use App\Enums\SharesAllowFlag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('content');
            $table->enum('visibility', PostVisibility::list());
            $table->boolean('is_comments_allowed')->default(CommentsAllowFlag::ALLOW);
            $table->boolean('is_shares_allowed')->default(SharesAllowFlag::ALLOW);
            $table->foreignId('reply_to_post_id')->nullable()->constrained('posts');
            $table->integer('like_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
