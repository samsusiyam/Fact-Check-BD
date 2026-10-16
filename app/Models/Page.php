<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title_bn', 'title_en', 'slug', 'content_bn', 'content_en', 'template', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
