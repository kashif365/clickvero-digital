<?php

use App\Http\Controllers\Admin\AdditionalContentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PageMetaController;
use App\Http\Controllers\Admin\PageSchemaController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\RobotRuleController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use App\Models\RobotRule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
| Public pages are rendered by the React app (resources/js). Each URL keeps its
| named Laravel route so server-side SEO tags, redirects, the sitemap, and route
| model binding keep working; the 'spa' view is the shell React mounts into.
*/
Route::view('/', 'spa')->name('home');
Route::view('/about', 'spa')->name('about');
Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog');
Route::get('/blog-details/{blog}', [PublicBlogController::class, 'show'])->name('blog-details');
Route::view('/contact', 'spa')->name('contact');
Route::view('/faq', 'spa')->name('faq');
Route::view('/pricing', 'spa')->name('pricing');
Route::view('/project', 'spa')->name('project');
Route::view('/project-details', 'spa')->name('project-details');
Route::get('/service', [ServiceController::class, 'index'])->name('service');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('service.show');
Route::redirect('/service-details', '/service', 301);
Route::view('/team', 'spa')->name('team');
Route::view('/team-details', 'spa')->name('team-details');

Route::post('/contact', [QuoteController::class, 'store'])->middleware('throttle:6,1')->name('quote.store');

Route::get('/robots.txt', function () {
    if (Storage::disk('public')->exists('robots-upload.txt')) {
        return response(Storage::disk('public')->get('robots-upload.txt'), 200, ['Content-Type' => 'text/plain']);
    }

    return response(RobotRule::renderTxt(), 200, ['Content-Type' => 'text/plain']);
});

Route::get('/sitemap.xml', function () {
    abort_unless(Storage::disk('public')->exists('sitemap.xml'), 404);

    return response(Storage::disk('public')->get('sitemap.xml'), 200, ['Content-Type' => 'application/xml']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('blogs', AdminBlogController::class)->except('show');
        Route::post('blogs-content-image', [AdminBlogController::class, 'uploadContentImage'])->name('blogs.content-image');

        Route::resource('additional-contents', AdditionalContentController::class)->except('show');
        Route::post('additional-contents-image', [AdditionalContentController::class, 'uploadContentImage'])->name('additional-contents.content-image');

        Route::resource('services', AdminServiceController::class)->except('show');
        Route::post('services-content-image', [AdminServiceController::class, 'uploadContentImage'])->name('services.content-image');

        Route::resource('testimonials', TestimonialController::class)->except('show');
        Route::resource('team-members', TeamMemberController::class)->except('show');

        Route::get('quotes', [AdminQuoteController::class, 'index'])->name('quotes.index');
        Route::get('quotes/{quote}', [AdminQuoteController::class, 'show'])->name('quotes.show');
        Route::delete('quotes/{quote}', [AdminQuoteController::class, 'destroy'])->name('quotes.destroy');

        Route::get('page-metas', [PageMetaController::class, 'index'])->name('page-metas.index');
        Route::get('page-metas/create', [PageMetaController::class, 'create'])->name('page-metas.create');
        Route::post('page-metas', [PageMetaController::class, 'store'])->name('page-metas.store');
        Route::get('page-metas/{pageMeta}/edit', [PageMetaController::class, 'edit'])->name('page-metas.edit');
        Route::put('page-metas/{pageMeta}', [PageMetaController::class, 'update'])->name('page-metas.update');
        Route::delete('page-metas/{pageMeta}', [PageMetaController::class, 'destroy'])->name('page-metas.destroy');

        Route::resource('redirects', RedirectController::class)->except('show');
        Route::patch('redirects/{redirect}/toggle', [RedirectController::class, 'toggle'])->name('redirects.toggle');
        Route::post('redirects-bulk', [RedirectController::class, 'bulk'])->name('redirects.bulk');

        Route::resource('page-schemas', PageSchemaController::class)->except('show');
        Route::patch('page-schemas/{page_schema}/toggle', [PageSchemaController::class, 'toggle'])->name('page-schemas.toggle');
        Route::post('page-schemas/{page_schema}/duplicate', [PageSchemaController::class, 'duplicate'])->name('page-schemas.duplicate');

        Route::get('seo-settings', [SeoSettingController::class, 'edit'])->name('seo-settings.edit');
        Route::put('seo-settings', [SeoSettingController::class, 'update'])->name('seo-settings.update');

        Route::get('robots', [RobotRuleController::class, 'index'])->name('robots.index');
        Route::post('robots', [RobotRuleController::class, 'store'])->name('robots.store');
        Route::delete('robots/{robot}', [RobotRuleController::class, 'destroy'])->name('robots.destroy');
        Route::get('robots-download', [RobotRuleController::class, 'download'])->name('robots.download');
        Route::post('robots-upload', [RobotRuleController::class, 'uploadFile'])->name('robots.upload');
        Route::delete('robots-upload', [RobotRuleController::class, 'destroyFile'])->name('robots.upload.destroy');
        Route::get('robots-upload-download', [RobotRuleController::class, 'downloadFile'])->name('robots.upload.download');

        Route::get('sitemap', [SitemapController::class, 'index'])->name('sitemap.index');
        Route::post('sitemap', [SitemapController::class, 'store'])->name('sitemap.store');
        Route::delete('sitemap', [SitemapController::class, 'destroy'])->name('sitemap.destroy');
        Route::get('sitemap-download', [SitemapController::class, 'download'])->name('sitemap.download');
        Route::post('sitemap-generate', [SitemapController::class, 'generate'])->name('sitemap.generate');
    });
});

Route::fallback(fn () => response()->view('spa', [], 404));
