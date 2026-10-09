<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:24'],
        ]);

        $query = Blog::query();

        if ($search = trim((string) ($filters['search'] ?? ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($category = $filters['category'] ?? null) {
            $query->where('category', $category);
        }

        $blogs = $query->orderByDesc('published_at')->orderByDesc('id')
            ->paginate($filters['per_page'] ?? 9)
            ->withQueryString();

        return BlogResource::collection($blogs)->additional([
            'categories' => Blog::query()->whereNotNull('category')->where('category', '!=', '')
                ->distinct()->orderBy('category')->pluck('category'),
        ]);
    }

    public function show(Blog $blog)
    {
        $related = Blog::where('id', '!=', $blog->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get(['id', 'title', 'slug', 'category', 'author', 'image', 'excerpt', 'published_at']);

        return (new BlogResource($blog))->additional([
            'related' => $related->map(fn (Blog $item) => [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'category' => $item->category,
                'author' => $item->author,
                'image' => $item->image,
                'excerpt' => $item->excerpt,
                'published_at' => $item->published_at?->toDateString(),
            ]),
        ]);
    }
}
