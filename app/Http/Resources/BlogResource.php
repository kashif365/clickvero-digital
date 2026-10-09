<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category,
            'author' => $this->author,
            'image' => $this->image,
            'excerpt' => $this->excerpt,
            'published_at' => $this->published_at?->toDateString(),
            // The sanitized article body is only sent on the detail endpoint.
            'content' => $this->when($request->routeIs('api.blogs.show'),$this->content),
        ];
    }
}
