<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
| Public JSON API consumed by the React frontend. Admin features stay on the
| session-authenticated Blade panel under /admin (see routes/web.php).
*/
Route::prefix('v1')->name('api.')->group(function () {
    Route::get('site', [SiteController::class, 'show'])->name('site');
    Route::get('page', [PageController::class, 'show'])->name('page');

    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');

    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

    Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('team', [TeamController::class, 'index'])->name('team.index');

    Route::post('quotes', [QuoteController::class, 'store'])->middleware('throttle:6,1')->name('quotes.store');
});
