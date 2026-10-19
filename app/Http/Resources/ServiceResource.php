<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'headline' => $this->headline,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'banner_image' => $this->banner_image,
            // Rich-text fields are only sent on the detail endpoint.
            'description' => $this->when($request->routeIs('api.services.show'), $this->description),
            'faqs' => $this->when($request->routeIs('api.services.show'), fn () => $this->faqList()),
        ];
    }
}
