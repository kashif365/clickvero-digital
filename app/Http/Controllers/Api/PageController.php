<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdditionalContent;
use App\Services\SeoResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class PageController extends Controller
{
    /**
     * Per-page data the React router needs after a client-side navigation: the
     * same SEO values the server renders into the SPA shell on a full page load,
     * plus the admin-managed "additional content" block for that path.
     */
    public function show(Request $request, SeoResolver $seo)
    {
        $data = $request->validate([
            'path' => ['required', 'string', 'max:500', 'starts_with:/'],
        ]);

        $path = AdditionalContent::normalizePath($data['path']);
        [$routeName, $model, $found] = $this->matchWebRoute($path);

        $resolved = $seo->resolveFor($routeName, $model, url($path));

        if (! $found) {
            // Mirrors the 404 the web route returns for this path on a full page load.
            $resolved = ['title' => 'Page Not Found', 'description' => null, 'robotsIndex' => false] + $resolved;
        }
        $additional = AdditionalContent::forCurrentPath($path);

        return response()->json([
            'data' => [
                'seo' => [
                    'title' => $resolved['title'],
                    'description' => $resolved['description'],
                    'canonical' => $resolved['canonical'],
                    'robots' => ($resolved['robotsIndex'] ? 'index' : 'noindex').','.($resolved['robotsFollow'] ? 'follow' : 'nofollow'),
                ],
                'additional_content' => $additional ? [
                    'title' => $additional->title,
                    'content' => $additional->content,
                ] : null,
            ],
        ]);
    }

    /**
     * Resolves which named web route (and bound model, if any) serves the given
     * path, so SEO data is looked up exactly as it is for a full page load.
     */
    private function matchWebRoute(string $path): array
    {
        try {
            $route = Route::getRoutes()->match(Request::create($path, 'GET'));
        } catch (HttpExceptionInterface) {
            return [null, null, false];
        }

        if ($route->isFallback) {
            return [null, null, false];
        }

        $model = null;
        $found = true;

        foreach ($route->signatureParameters(['subClass' => Model::class]) as $parameter) {
            $class = $parameter->getType()->getName();
            $key = (new $class)->getRouteKeyName();
            $model = $class::where($key, $route->parameter($parameter->getName()))->first();
            $found = $model !== null && ($model->status ?? true);
        }

        return [$route->getName(), $model, $found];
    }
}
