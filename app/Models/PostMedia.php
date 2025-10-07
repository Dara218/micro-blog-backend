<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    /** @use HasFactory<\Database\Factories\PostMediaFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'post_id',
        'type',
        'url',
        'mime_type',
        'width',
        'height',
        'duration_seconds',
        'sort_order',
    ];
}
