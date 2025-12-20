<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kuliner_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Boot function to update kuliner rating after save
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($rating) {
            $rating->kuliner->updateAverageRating();
        });

        static::deleted(function ($rating) {
            $rating->kuliner->updateAverageRating();
        });
    }

    /**
     * Get the user who gave this rating
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the kuliner being rated
     */
    public function kuliner(): BelongsTo
    {
        return $this->belongsTo(Kuliner::class);
    }
    //
}
