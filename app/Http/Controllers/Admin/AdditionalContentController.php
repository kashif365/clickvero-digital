<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdditionalContentController extends Controller
{
    /**
     * Path prefixes that may never be targeted, so this feature can't accidentally
     * inject rendered content onto system/framework routes.
     */
    private const PROTECTED_PREFIXES = [
        '/admin', '/api', '/storage', '/build', '/assets', '/login', '/logout', '/up',
    ];

    public function index(Request $request)
    {
        $query = AdditionalContent::query();

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('page_url', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status === 'active');
        }

        return view('admin.additional-contents.index', [
            'contents' => $query->latest()->paginate(15)->withQueryString(),
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        return view('admin.additional-contents.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        AdditionalContent::create($data);

        return redirect()->route('admin.additional-contents.index')->with('success', 'Additional content created.');
    }

    public function edit(AdditionalContent $additionalContent)
    {
        return view('admin.additional-contents.edit', ['content' => $additionalContent]);
    }

    public function update(Request $request, AdditionalContent $additionalContent)
    {
        $data = $this->validated($request, $additionalContent);

        $additionalContent->update($data);

        return redirect()->route('admin.additional-contents.index')->with('success', 'Additional content updated.');
    }

    public function destroy(AdditionalContent $additionalContent)
    {
        $additionalContent->delete();

        return redirect()->route('admin.additional-contents.index')->with('success', 'Additional content deleted.');
    }

    /**
     * Image upload endpoint for the CKEditor SimpleUploadAdapter on the content field.
     */
    public function uploadContentImage(Request $request)
    {
        try {
            $request->validate([
                'upload' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => ['message' => collect($e->errors())->flatten()->first()],
            ], 422);
        }

        $path = Storage::disk('public')->putFile('additional-content', $request->file('upload'));

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }

    private function validated(Request $request, ?AdditionalContent $content = null): array
    {
        $data = $request->validate([
            'page_url' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $normalized = AdditionalContent::normalizePath($data['page_url']);

        foreach (self::PROTECTED_PREFIXES as $prefix) {
            if ($normalized === $prefix || str_starts_with($normalized, $prefix.'/')) {
                throw ValidationException::withMessages([
                    'page_url' => 'This path is reserved by the application and cannot have additional content attached.',
                ]);
            }
        }

        $duplicateQuery = AdditionalContent::where('page_url', $normalized);
        if ($content) {
            $duplicateQuery->where('id', '!=', $content->id);
        }
        if ($duplicateQuery->exists()) {
            throw ValidationException::withMessages([
                'page_url' => 'Additional content for this page URL already exists. Edit the existing record instead.',
            ]);
        }

        $data['page_url'] = $normalized;
        $data['status'] = $request->boolean('status', true);

        return $data;
    }
}
