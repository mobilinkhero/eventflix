<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image ? (filter_var($this->image, FILTER_VALIDATE_URL) ? $this->image : url('uploads/' . $this->image)) : null,
            'account_type' => $this->account_type,
            'city' => new CityResource($this->whenLoaded('city')),
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
