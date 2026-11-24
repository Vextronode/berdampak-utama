<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'year',
        'summary',
        'description',
        'problem_statement',
        'features',
        'gallery_images',
        'partner_name',
        'category',
        'tech_stacks',
        'dashboard_thumbnail',
        'live_url',
        'supervisor_name',
        'supervisor_title',
        'supervisor_photo_url',
        'is_published',
    ];

    protected $casts = [
        'year' => 'integer',
        'tech_stacks' => 'array',
        'features' => 'array',
        'gallery_images' => 'array',
        'is_published' => 'boolean',
    ];

    public function contributors(): HasMany
    {
        return $this->hasMany(ProjectContributor::class)->orderBy('sort_order');
    }

    public function techStackItems(): BelongsToMany
    {
        return $this->belongsToMany(TechStack::class, 'project_tech_stack');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFilterByYear(Builder $query, ?string $year): Builder
    {
        if ($year && $year !== 'semua') {
            return $query->where('year', (int) $year);
        }

        return $query;
    }

    public function scopeFilterByCategory(Builder $query, ?string $category): Builder
    {
        if ($category && $category !== 'semua') {
            return $query->where('category', $category);
        }

        return $query;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! empty($term)) {
            return $query->where(function (Builder $q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('summary', 'like', "%{$term}%")
                    ->orWhere('partner_name', 'like', "%{$term}%")
                    ->orWhereHas('contributors', function (Builder $cq) use ($term) {
                        $cq->where('name', 'like', "%{$term}%")
                            ->orWhere('npm', 'like', "%{$term}%")
                            ->orWhere('major', 'like', "%{$term}%");
                    });
            });
        }

        return $query;
    }
}
