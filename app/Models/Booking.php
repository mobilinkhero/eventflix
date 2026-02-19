<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_number',
        'user_id',
        'vendor_id',
        'event_type',
        'event_date',
        'event_time',
        'guest_count',
        'requirements',
        'contact_name',
        'contact_phone',
        'contact_email',
        'quoted_price',
        'final_price',
        'advance_paid',
        'status',
        'cancellation_reason',
        'admin_notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'quoted_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'advance_paid' => 'decimal:2',
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

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled', 'rejected', 'completed']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Auto-generate booking number
    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'EW-' . strtoupper(uniqid());
            }
        });
    }

    // Helpers
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'viewed', 'quoted', 'confirmed']);
    }

    public function canBeReviewed(): bool
    {
        return $this->status === 'completed' && !$this->review;
    }
}
