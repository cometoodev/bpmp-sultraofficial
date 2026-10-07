<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'author_id',
        'excerpt',
        'content',
        'thumbnail',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'views' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && ($this->published_at === null || $this->published_at <= now());
    }

    public function getSeoTitle(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getSeoDescription(): string
    {
        if (! empty($this->meta_description)) {
            return $this->meta_description;
        }

        if (! empty($this->excerpt)) {
            return $this->excerpt;
        }

        return str($this->content ? strip_tags($this->content) : '')->limit(160)->toString();
    }
}
