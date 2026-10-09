<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Quote;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'blogsCount' => Blog::count(),
            'quotesCount' => Quote::count(),
            'latestQuotes' => Quote::latest()->take(5)->get(),
        ]);
    }
}
