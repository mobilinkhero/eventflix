<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'city_id',
        'account_type',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ─── Relationships ──────────────────────────

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Vendor::class, 'favorites')->withTimestamps();
    }

    // ─── Helpers ────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->account_type === 'admin';
    }

    public function isVendor(): bool
    {
        return $this->account_type === 'vendor';
    }

    public function hasFavorited(Vendor $vendor): bool
    {
        return $this->favorites()->where('vendor_id', $vendor->id)->exists();
    }
}
