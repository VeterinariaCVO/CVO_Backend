<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('active', true)->get();

        return ServiceResource::collection($services);
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return new ServiceResource($service);
    }

    public function show(Service $service)
    {
        return new ServiceResource($service->load('appointments'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return new ServiceResource($service);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }
}
