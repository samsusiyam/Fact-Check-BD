<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name_bn', 'name_en', 'slug', 'description_bn', 'description_en', 'order_column'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
