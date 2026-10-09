<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SitePayload;

class SiteController extends Controller
{
    public function show(SitePayload $site)
    {
        return response()->json(['data' => $site->toArray()]);
    }
}
