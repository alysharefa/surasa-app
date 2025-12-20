<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Kuliner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'location',
        'address',
        'latitude',
        'longitude',
        'price_min',
        'price_max',
        'image',
        'gallery',
        'contact',
        'open_hours',
        'is_featured',
        'is_active',
        'average_rating',
        'total_reviews',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Boot function to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kuliner) {
            if (empty($kuliner->slug)) {
                $kuliner->slug = Str::slug($kuliner->name);
            }
        });
    }

    /**
     * Get the category of this kuliner
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get ratings for this kuliner
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get comments for this kuliner
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get recipes related to this kuliner
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Update average rating after new rating
     */
    public function updateAverageRating(): void
    {
        $this->average_rating = $this->ratings()->avg('rating') ?? 0;
        $this->total_reviews = $this->ratings()->count();
        $this->save();
    }

    /**
     * Scope for active kuliners
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured kuliners
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for top rated kuliners
     */
    public function scopeTopRated($query, $limit = 10)
    {
        return $query->orderBy('average_rating', 'desc')->limit($limit);
    }

    /**
     * Get formatted price range
     */
    public function getPriceRangeAttribute(): string
    {
        if ($this->price_min && $this->price_max) {
            return 'Rp ' . number_format($this->price_min, 0, ',', '.') . ' - Rp ' . number_format($this->price_max, 0, ',', '.');
        } elseif ($this->price_min) {
            return 'Mulai Rp ' . number_format($this->price_min, 0, ',', '.');
        }
        return 'Harga tidak tersedia';
    }

    /**
     * Get all likes for this kuliner
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Check if kuliner is liked by specific user
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    //
}
