<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        $query = Redirect::query()->with('creator');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('source_path', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->input('status')) {
            $query->where('is_active', $status === 'active');
        }

        return view('admin.redirects.index', [
            'redirects' => $query->latest()->paginate(15)->withQueryString(),
            'filters' => $request->only(['search', 'type', 'status']),
            'types' => Redirect::TYPES,
        ]);
    }

    public function create()
    {
        return view('admin.redirects.create', ['types' => Redirect::TYPES]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()?->id;

        Redirect::create($data);

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect created.');
    }

    public function edit(Redirect $redirect)
    {
        return view('admin.redirects.edit', ['redirect' => $redirect, 'types' => Redirect::TYPES]);
    }

    public function update(Request $request, Redirect $redirect)
    {
        $data = $this->validated($request, $redirect);
        $redirect->update($data);

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect updated.');
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect deleted.');
    }

    public function toggle(Redirect $redirect)
    {
        $redirect->update(['is_active' => ! $redirect->is_active]);

        return back()->with('success', 'Redirect '.($redirect->is_active ? 'activated' : 'deactivated').'.');
    }

    public function bulk(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete'],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:redirects,id'],
        ]);

        $redirects = Redirect::whereIn('id', $request->input('ids'));

        match ($request->input('action')) {
            'activate' => $redirects->update(['is_active' => true]),
            'deactivate' => $redirects->update(['is_active' => false]),
            'delete' => $redirects->get()->each->delete(),
        };

        Redirect::flushCache();

        return back()->with('success', 'Bulk action applied.');
    }

    private function validated(Request $request, ?Redirect $redirect = null): array
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'source_path' => ['required', 'string', 'max:2048'],
            'destination' => ['required', 'string', 'max:2048'],
            'type' => ['required', 'integer', Rule::in(Redirect::TYPES)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $sourcePath = Redirect::normalizePath($data['source_path']);
        $destination = trim($data['destination']);

        if (Redirect::isProtectedPath($sourcePath)) {
            throw ValidationException::withMessages([
                'source_path' => 'This path is reserved by the application (admin, API, storage, assets, auth, or system routes) and cannot be redirected.',
            ]);
        }

        if (! Redirect::isSafeDestination($destination)) {
            throw ValidationException::withMessages([
                'destination' => 'Destination must be an internal path starting with "/" or a valid http(s):// URL.',
            ]);
        }

        $isInternal = str_starts_with($destination, '/');
        if ($isInternal) {
            $destination = Redirect::normalizePath($destination);
        }

        if ($sourcePath === $destination) {
            throw ValidationException::withMessages([
                'destination' => 'A redirect cannot point to itself.',
            ]);
        }

        $duplicateQuery = Redirect::where('source_path', $sourcePath);
        if ($redirect) {
            $duplicateQuery->where('id', '!=', $redirect->id);
        }
        if ($duplicateQuery->exists()) {
            throw ValidationException::withMessages([
                'source_path' => 'A redirect for this source path already exists.',
            ]);
        }

        // A destination that is itself already someone else's redirect source would create
        // a chain (A -> B -> C) or, symmetrically, a loop (A -> B while B -> A already exists).
        // Blocking it here prevents both cases at once.
        if ($isInternal) {
            $chainQuery = Redirect::where('source_path', $destination)->where('is_active', true);
            if ($redirect) {
                $chainQuery->where('id', '!=', $redirect->id);
            }
            if ($chainQuery->exists()) {
                throw ValidationException::withMessages([
                    'destination' => 'This destination is already the source of another active redirect. Chained/looping redirects are not allowed — point directly to the final destination.',
                ]);
            }
        }

        $data['source_path'] = $sourcePath;
        $data['destination'] = $destination;

        return $data;
    }
}
