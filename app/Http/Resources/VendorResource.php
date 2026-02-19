<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email,
            'website' => $this->website,
            'address' => $this->address,
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'pricing' => [
                'min' => (float) $this->price_min,
                'max' => (float) $this->price_max,
                'unit' => $this->price_unit,
                'formatted' => $this->price_range_formatted,
            ],
            'rating' => (float) $this->rating,
            'total_reviews' => $this->total_reviews,
            'total_bookings' => $this->total_bookings,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'gallery' => $this->gallery ? collect($this->gallery)->map(fn($img) => url('storage/' . $img)) : [],
            'social_links' => $this->social_links,
            'is_verified' => $this->is_verified,
            'is_featured' => $this->is_featured,
            'city' => new CityResource($this->whenLoaded('city')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'is_favorited' => $this->when(
                auth('sanctum')->check(),
                fn() => auth('sanctum')->user()->hasFavorited($this->resource)
            ),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
