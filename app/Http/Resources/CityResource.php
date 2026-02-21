<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'province' => $this->province,
            'image' => $this->image ? (filter_var($this->image, FILTER_VALIDATE_URL) ? $this->image : url('storage/' . $this->image)) : null,
            'vendor_count' => $this->vendors_count ?? ($this->relationLoaded('vendors') ? $this->vendors->count() : 0),
        ];
    }
}
