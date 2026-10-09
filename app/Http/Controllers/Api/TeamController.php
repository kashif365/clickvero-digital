<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => TeamMember::active()->ordered()->get(['id', 'name', 'role', 'bio', 'photo']),
        ]);
    }
}
