<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id', 'category_id', 'title_bn', 'title_en', 'slug',
        'excerpt_bn', 'excerpt_en', 'content_bn', 'content_en',
        'claim_text_bn', 'claim_text_en', 'claim_claimant_bn', 'claim_claimant_en',
        'claim_origin_bn', 'claim_origin_en', 'claim_date', 'verdict',
        'verification_steps_bn', 'verification_steps_en', 'sources',
        'status', 'published_at', 'scheduled_at', 'factcheck_updated_at',
        'correction_note_bn', 'correction_note_en', 'is_lead', 'views_count'
    ];

    protected $casts = [
        'sources' => 'array',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'factcheck_updated_at' => 'datetime',
        'is_lead' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(160)
            ->height(160)
            ->format('webp');

        $this->addMediaConversion('medium')
            ->width(640)
            ->height(400)
            ->format('webp');

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(750)
            ->format('webp');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getVerdictLabel(string $locale = 'bn'): string
    {
        $labels = [
            'false' => ['bn' => 'ভুয়া', 'en' => 'False'],
            'misleading' => ['bn' => 'বিভ্রান্তিকর', 'en' => 'Misleading'],
            'true' => ['bn' => 'সত্য', 'en' => 'True'],
            'ai_generated' => ['bn' => 'এআই-নির্মিত', 'en' => 'AI Generated'],
            'unproven' => ['bn' => 'অপ্রমাণিত', 'en' => 'Unproven'],
        ];

        return $labels[$this->verdict][$locale] ?? $labels[$this->verdict]['bn'];
    }
}
