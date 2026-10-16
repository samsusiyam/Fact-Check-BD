<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends Model
{
    protected $fillable = [
        'submitter_name',
        'submitter_email',
        'submitter_phone',
        'claim_text',
        'claim_url',
        'attachment_path',
        'status',
        'admin_notes',
        'post_id',
        'ip_address',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
