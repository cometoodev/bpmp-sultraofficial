<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'html_content',
        'builder_data',
        'editor_mode',
        'featured_image',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
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

    public function getDesignMethodAttribute(): string
    {
        return $this->editor_mode === 'visual' ? 'builder' : 'html';
    }

    public function isBuilder(): bool
    {
        return $this->editor_mode === 'visual' || $this->design_method === 'builder';
    }

    public function getUrlAttribute(): string
    {
        return url($this->slug);
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

        return str($this->content ? strip_tags($this->content) : '')->limit(160)->toString();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(PageAttachment::class)->orderBy('order_position', 'asc')->orderBy('id', 'asc');
    }

    public function activeAttachments(): HasMany
    {
        return $this->hasMany(PageAttachment::class)->where('is_active', true)->orderBy('order_position', 'asc')->orderBy('id', 'asc');
    }
}
