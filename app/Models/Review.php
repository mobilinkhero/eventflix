<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'booking_id',
        'rating',
        'comment',
        'vendor_reply',
        'vendor_replied_at',
        'status',
        'is_anonymous',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'vendor_replied_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Boot
    protected static function booted(): void
    {
        static::created(function (Review $review) {
            $review->vendor->recalculateRating();
        });

        static::updated(function (Review $review) {
            $review->vendor->recalculateRating();
        });

        static::deleted(function (Review $review) {
            $review->vendor->recalculateRating();
        });
    }
}
