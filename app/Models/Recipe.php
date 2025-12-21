<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kuliner_id',
        'title',
        'slug',
        'description',
        'ingredients',
        'steps',
        'image',
        'prep_time',
        'cooking_time',
        'servings',
        'difficulty',
        'tips',
        'is_approved',
        'views',
        'calories',
        'protein',
        'fat',
        'carbs',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
        'is_approved' => 'boolean',
        'prep_time' => 'integer',
        'cooking_time' => 'integer',
        'servings' => 'integer',
        'views' => 'integer',
        'calories' => 'integer',
        'protein' => 'integer',
        'fat' => 'integer',
        'carbs' => 'integer',
    ];

    /**
     * Boot function to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            if (empty($recipe->slug)) {
                $recipe->slug = Str::slug($recipe->title) . '-' . Str::random(5);
            }
        });
    }

    /**
     * Get the user who wrote this recipe
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related kuliner (optional)
     */
    public function kuliner(): BelongsTo
    {
        return $this->belongsTo(Kuliner::class);
    }

    /**
     * Scope for approved recipes
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for pending approval
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Get formatted cooking time
     */
    public function getFormattedCookingTimeAttribute(): string
    {
        if (!$this->cooking_time) {
            return 'Tidak tersedia';
        }

        $hours = floor($this->cooking_time / 60);
        $minutes = $this->cooking_time % 60;

        if ($hours > 0) {
            return $hours . ' jam ' . ($minutes > 0 ? $minutes . ' menit' : '');
        }

        return $minutes . ' menit';
    }

    /**
     * Get difficulty label in Indonesian
     */
    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'mudah' => 'Mudah',
            'sedang' => 'Sedang',
            'sulit' => 'Sulit',
            default => 'Tidak diketahui',
        };
    }

    /**
     * Get users who bookmarked this recipe
     */
    public function bookmarkedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    /**
     * Get all likes for this recipe
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Check if recipe is liked by specific user
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    //
}
