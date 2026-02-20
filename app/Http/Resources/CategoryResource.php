<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $icon = $this->icon;
        $iconImage = null;

        // If icon starts with 'uploaded:', it's a file path
        if (str_starts_with($icon ?? '', 'uploaded:')) {
            $iconImage = url('storage/' . str_replace('uploaded:', '', $icon));
            $icon = 'category'; // fallback material icon name
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $icon,
            'icon_image' => $iconImage,
            'color' => $this->color,
            'description' => $this->description,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'vendor_count' => $this->when($this->relationLoaded('vendors'), fn() => $this->vendors->count()),
        ];
    }
}
