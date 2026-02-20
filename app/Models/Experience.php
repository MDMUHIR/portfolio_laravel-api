<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organization',
        'description',
        'start_date',
        'end_date',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public const TYPES = [
        'job' => 'Job',
        'education' => 'Education',
    ];

    public function scopeJobs($query)
    {
        return $query->where('type', 'job');
    }

    public function scopeEducation($query)
    {
        return $query->where('type', 'education');
    }

    public function scopeCurrent($query)
    {
        return $query->whereNull('end_date');
    }

    public function getDurationAttribute(): string
    {
        $start = $this->start_date->format('M Y');
        $end = $this->end_date ? $this->end_date->format('M Y') : 'Present';
        return "{$start} - {$end}";
    }

    public function getIsCurrentAttribute(): bool
    {
        return is_null($this->end_date);
    }
}
