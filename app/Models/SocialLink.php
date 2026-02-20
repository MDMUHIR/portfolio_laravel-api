<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'url',
        'icon',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public const PLATFORMS = [
        'github' => 'GitHub',
        'linkedin' => 'LinkedIn',
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'youtube' => 'YouTube',
        'dribbble' => 'Dribbble',
        'behance' => 'Behance',
        'stackoverflow' => 'Stack Overflow',
        'website' => 'Personal Website',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
