<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'proficiency_level',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'proficiency_level' => 'integer',
        ];
    }

    public const CATEGORIES = [
        'frontend' => 'Frontend',
        'backend' => 'Backend',
        'tools' => 'Tools',
        'database' => 'Database',
        'devops' => 'DevOps',
    ];

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFrontend($query)
    {
        return $query->where('category', 'frontend');
    }

    public function scopeBackend($query)
    {
        return $query->where('category', 'backend');
    }

    public function scopeTools($query)
    {
        return $query->where('category', 'tools');
    }

    public function getIconUrlAttribute(): string
    {
        if ($this->icon) {
            return asset('storage/' . $this->icon);
        }
        return asset('images/default-skill.png');
    }
}
