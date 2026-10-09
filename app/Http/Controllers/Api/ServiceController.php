<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return ServiceResource::collection(Service::active()->ordered()->get());
    }

    public function show(Service $service)
    {
        abort_unless($service->status, 404);

        return new ServiceResource($service);
    }
}
