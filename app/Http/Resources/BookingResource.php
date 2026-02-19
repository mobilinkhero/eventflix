<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_number' => $this->booking_number,
            'event_type' => $this->event_type,
            'event_date' => $this->event_date->format('Y-m-d'),
            'event_time' => $this->event_time,
            'guest_count' => $this->guest_count,
            'requirements' => $this->requirements,
            'contact' => [
                'name' => $this->contact_name,
                'phone' => $this->contact_phone,
                'email' => $this->contact_email,
            ],
            'pricing' => [
                'quoted' => (float) $this->quoted_price,
                'final' => (float) $this->final_price,
                'advance_paid' => (float) $this->advance_paid,
            ],
            'status' => $this->status,
            'can_cancel' => $this->canBeCancelled(),
            'can_review' => $this->canBeReviewed(),
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'user' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
            ]),
            'review' => new ReviewResource($this->whenLoaded('review')),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
