<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request)
    {
        $quote = Quote::create($request->validated());

        return response()->json([
            'message' => 'Thanks! Your message has been sent — we\'ll be in touch shortly.',
            'data' => ['id' => $quote->id],
        ], 201);
    }
}
