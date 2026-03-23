<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Appointment::with([
            'pet',
            'timeSlot.workingDay',
            'creator'
        ]);

        if ($user->role_id === 3) {
            $query->whereHas('pet', function ($q) use ($user) {
                $q->where('owner_id', $user->id);
            });
        }

        if (request()->has('status')) {
            $query->where('status', request('status'));
        }

        return AppointmentResource::collection($query->get());
    }

    public function store(AppointmentRequest $request)
    {
        $slot = TimeSlot::with('workingDay')->findOrFail($request->time_slot_id);

        if ($slot->status === 'reserved') {
            return response()->json([
                'message' => 'Horario no disponible'
            ], 400);
        }

        $fecha = $slot->workingDay->date;
        if (Carbon::parse($fecha)->isToday()) {
            return response()->json([
                'message' => 'Debes agendar con al menos 1 día de anticipacion'
            ], 400);
        }

        $appointment = Appointment::create([
            'pet_id' => $request->pet_id,
            'time_slot_id' => $request->time_slot_id,
            'service' => $request->service,
            'status' => 'pending',
            'notes' => $request->notes,
            'created_by' => Auth::id() ?? 1
        ]);

        $slot->update([
            'status' => 'reserved'
        ]);

        return new AppointmentResource($appointment);
    }

    public function show($id)
    {
        $appointment = Appointment::with([
            'pet.client',
            'timeSlot.workingDay',
            'creator'
        ])->findOrFail($id);

        return new AppointmentResource($appointment);
    }

    public function update(AppointmentRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $newSlot = TimeSlot::with('workingDay')->findOrFail($request->time_slot_id);

        if ($newSlot->status === 'reserved') {
            return response()->json([
                'message' => 'Horario ocupado'
            ], 400);
        }

        $fecha = $newSlot->workingDay->date;
        if (Carbon::parse($fecha)->isToday()) {
            return response()->json([
                'message' => 'Debes reagendar con al menos 1 día de anticipacion'
            ], 400);
        }

        $oldSlot = TimeSlot::findOrFail($appointment->time_slot_id);
        $oldSlot->update(['status' => 'available']);

        $newSlot->update(['status' => 'reserved']);

        $appointment->update([
            'pet_id' => $request->pet_id,
            'time_slot_id' => $request->time_slot_id,
            'service' => $request->service,
            'notes' => $request->notes
        ]);

        return new AppointmentResource($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $slot = TimeSlot::findOrFail($appointment->time_slot_id);

        $slot->update([
            'status' => 'available'
        ]);

        $appointment->update([
            'status' => 'cancelled'
        ]);

        return response()->json([
            'message' => 'Cita cancelada correctamente'
        ]);
    }
}
