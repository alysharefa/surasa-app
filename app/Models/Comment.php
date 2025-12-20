<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kuliner_id',
        'content',
        'images',
        'is_approved',
    ];

    protected $casts = [
        'images' => 'array',
        'is_approved' => 'boolean',
    ];

    /**
     * Get the user who wrote this comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the kuliner being commented on
     */
    public function kuliner(): BelongsTo
    {
        return $this->belongsTo(Kuliner::class);
    }

    /**
     * Get rating attribute from related rating table
     */
    public function getRatingAttribute()
    {
        $rating = Rating::where('user_id', $this->user_id)
            ->where('kuliner_id', $this->kuliner_id)
            ->first();
            
        return $rating ? $rating->rating : 0;
    }

    /**
     * Scope for approved comments
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
    //
}
