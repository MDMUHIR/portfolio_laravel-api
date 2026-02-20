<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'tech_stack',
        'project_url',
        'github_url',
        'featured_image',
        'status',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tag');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/default-project.png');
    }
}
