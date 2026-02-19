<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'color' => $this->color,
            'description' => $this->description,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'vendor_count' => $this->when($this->relationLoaded('vendors'), fn() => $this->vendors->count()),
        ];
    }
}
