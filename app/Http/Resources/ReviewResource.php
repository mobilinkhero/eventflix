<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_anonymous' => $this->is_anonymous,
            'user' => $this->when(!$this->is_anonymous, [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar ? url('uploads/' . $this->user->avatar) : null,
            ]),
            'vendor_reply' => $this->vendor_reply,
            'vendor_replied_at' => $this->vendor_replied_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
