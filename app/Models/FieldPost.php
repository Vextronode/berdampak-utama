<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'slug',
        'activity_date',
        'cover_image',
        'summary',
        'content',
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
