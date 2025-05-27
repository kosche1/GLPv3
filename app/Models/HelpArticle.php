<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class HelpArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'help_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'tags',
        'view_count',
        'helpful_count',
        'not_helpful_count',
        'sort_order',
        'is_featured',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            if (empty($model->published_at) && $model->is_published) {
                $model->published_at = now();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            if ($model->isDirty('is_published') && $model->is_published && empty($model->published_at)) {
                $model->published_at = now();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'help_category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function markHelpful()
    {
        $this->increment('helpful_count');
    }

    public function markNotHelpful()
    {
        $this->increment('not_helpful_count');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return Str::limit(strip_tags($this->content), 150);
    }
}
