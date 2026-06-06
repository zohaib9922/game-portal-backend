<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'launch_type',
        'emulator_core',
        'rom_url',
        'external_url',
        'category',
        'embed_url',
        'thumbnail',
        'plays',
        'is_featured',
        'tags',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'tags' => 'array',
    ];

    public function incrementPlays(): void
    {
        $this->increment('plays');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                     ->orWhere('description', 'like', "%{$term}%");
    }

    
}
