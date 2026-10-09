<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('spa', [
            'services' => Service::active()->ordered()->get(),
        ]);
    }

    public function show(Service $service)
    {
        abort_unless($service->status, 404);

        return view('spa', ['service' => $service]);
    }
}
