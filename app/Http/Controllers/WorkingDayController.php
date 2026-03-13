<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkingDay;
use App\Http\Requests\WorkingDayRequest;
use App\Http\Resources\WorkingDayResource;

class WorkingDayController extends Controller
{
    public function index()
    {
        return WorkingDayResource::collection(
            WorkingDay::all()
        );
    }

    public function store(WorkingDayRequest $request)
    {
        $day = WorkingDay::create($request->validated());

        return new WorkingDayResource($day);
    }

    public function show($id)
    {
        $day = WorkingDay::findOrFail($id);

        return new WorkingDayResource($day);
    }

    public function update(WorkingDayRequest $request, $id)
    {
        $day = WorkingDay::findOrFail($id);

        $day->update($request->validated());

        return new WorkingDayResource($day);
    }

    public function destroy($id)
    {
        WorkingDay::destroy($id);

        return response()->json([
            'message' => 'Dia eliminado'
        ]);
    }
}
