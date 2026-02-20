<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_tag');
    }

    public static function findOrCreateByName(string $name): self
    {
        return static::firstOrCreate(
            ['slug' => \Str::slug($name)],
            ['name' => $name]
        );
    }
}
