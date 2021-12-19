<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\PostTag;
use App\Models\Comments;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = ['title', 'content'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Str::orderedUuid();
        });
    }

    public function scopeActive(Builder $query, $status)
    {
        return $query->where('status', $status);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id');
    }
    public function latestComment()
    {
        return $this->hasOne(Comments::class, 'post_id')->latestOfMany();
    }
    public function postTags()
    {
        return $this->belongsToMany(PostTag::class, 'posts_tags', 'post_id', 'tag_id')
            ->withTimestamps();
        // ->withPivot('active');
    }
}
