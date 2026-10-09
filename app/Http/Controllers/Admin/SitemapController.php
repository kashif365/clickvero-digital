<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SitemapGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    private const FILENAME = 'sitemap.xml';

    public function index()
    {
        $disk = Storage::disk('public');
        $exists = $disk->exists(self::FILENAME);

        return view('admin.sitemap.index', [
            'exists' => $exists,
            'updatedAt' => $exists ? $disk->lastModified(self::FILENAME) : null,
            'size' => $exists ? $disk->size(self::FILENAME) : null,
        ]);
    }

    public function generate(SitemapGenerator $generator)
    {
        $generator->regenerate();

        return redirect()->route('admin.sitemap.index')->with('success', 'Sitemap generated from current active, indexable pages and blog posts.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sitemap' => ['required', 'file', 'mimetypes:text/xml,application/xml', 'max:10240'],
        ]);

        Storage::disk('public')->putFileAs('', $request->file('sitemap'), self::FILENAME);

        return redirect()->route('admin.sitemap.index')->with('success', 'Sitemap uploaded.');
    }

    public function destroy()
    {
        Storage::disk('public')->delete(self::FILENAME);

        return redirect()->route('admin.sitemap.index')->with('success', 'Sitemap deleted.');
    }

    public function download()
    {
        return Storage::disk('public')->download(self::FILENAME, 'sitemap.xml');
    }
}
