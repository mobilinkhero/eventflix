<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Vendor extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'user_id',
        'city_id',
        'name',
        'slug',
        'description',
        'short_description',
        'phone',
        'whatsapp',
        'email',
        'website',
        'address',
        'latitude',
        'longitude',
        'price_min',
        'price_max',
        'price_unit',
        'rating',
        'total_reviews',
        'total_bookings',
        'image',
        'gallery',
        'social_links',
        'is_verified',
        'is_featured',
        'is_active',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'gallery' => 'array',
        'social_links' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'rating' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // ─── Relationships ─────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    // ─── Scopes ─────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeInCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    public function scopeInCategory($query, $categoryId)
    {
        return $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        });
    }

    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min)
            $query->where('price_min', '>=', $min);
        if ($max)
            $query->where('price_max', '<=', $max);
        return $query;
    }

    public function scopeMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    // ─── Helpers ────────────────────────────────────

    public function recalculateRating(): void
    {
        $approvedReviews = $this->reviews()->where('status', 'approved');
        $this->update([
            'rating' => round($approvedReviews->avg('rating') ?? 0, 2),
            'total_reviews' => $approvedReviews->count(),
        ]);
    }

    public function getPriceRangeFormattedAttribute(): string
    {
        if ($this->price_min && $this->price_max) {
            return 'PKR ' . number_format($this->price_min) . ' - ' . number_format($this->price_max);
        }
        if ($this->price_min) {
            return 'From PKR ' . number_format($this->price_min);
        }
        return 'Contact for pricing';
    }
}
