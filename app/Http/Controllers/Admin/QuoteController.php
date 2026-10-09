<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        return view('admin.quotes.index', [
            'quotes' => Quote::latest()->paginate(15),
        ]);
    }

    public function show(Quote $quote)
    {
        return view('admin.quotes.show', ['quote' => $quote]);
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('admin.quotes.index')->with('success', 'Quote deleted.');
    }
}
