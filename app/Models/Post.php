<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    MorphMany,
};

/**
 * @property bool $is_liked Dynamic property to indicate if the post is liked by the authenticated user.
 */
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'content',
        'visibility',
        'is_comments_allowed',
        'is_shares_allowed',
        'reply_to_post_id',
        'like_count',
        'comment_count',
        'share_count',
    ];

    /**
     * Get the user who created the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent post this is replying to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'reply_to_post_id');
    }

    /**
     * Get the replies to this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Post::class, 'reply_to_post_id');
    }

    /**
     * Get the comments on this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Get the media attached to this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }

    /**
     * Get the likes for this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Get the shares for this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }

    /**
     * Get the bookmarks for this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get the hashtags for this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hashtags(): HasMany
    {
        return $this->hasMany(PostHashtag::class);
    }

    /**
     * Get the mentions in this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions(): HasMany
    {
        return $this->hasMany(Mention::class);
    }
}
