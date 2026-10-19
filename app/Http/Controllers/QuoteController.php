<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request)
    {
        Quote::create($request->quoteData());

        return back()->with('success', 'Thanks! Your message has been sent — we\'ll be in touch shortly.');
    }
}
