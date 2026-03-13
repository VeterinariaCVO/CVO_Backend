<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Http\Requests\TimeSlotRequest;
use App\Http\Resources\TimeSlotResource;

class TimeSlotController extends Controller
{
    public function index()
    {
        return TimeSlotResource::collection(
            TimeSlot::with('workingDay')->get()
        );
    }

    public function store(TimeSlotRequest $request)
    {
        $slot = TimeSlot::create($request->validated());

        return new TimeSlotResource($slot);
    }

    public function show($id)
    {
        $slot = TimeSlot::with('workingDay')
            ->findOrFail($id);

        return new TimeSlotResource($slot);
    }

    public function update(TimeSlotRequest $request, $id)
    {
        $slot = TimeSlot::findOrFail($id);

        $slot->update($request->validated());

        return new TimeSlotResource($slot);
    }

    public function destroy($id)
    {
        TimeSlot::destroy($id);

        return response()->json([
            'message' => 'Horario eliminado'
        ]);
    }
}
