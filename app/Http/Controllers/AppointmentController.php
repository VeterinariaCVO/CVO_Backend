<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Crear cita
    public function store(AppointmentRequest $request)
    {
        $slot = TimeSlot::findOrFail($request->time_slot_id);

        if ($slot->status === 'reserved') {
            return response()->json([
                'message' => 'Horario no disponible'
            ], 400);
        }

        $appointment = Appointment::create([
            'pet_id' => $request->pet_id,
            'service_id' => $request->service_id,
            'time_slot_id' => $request->time_slot_id,
            'status' => 'pending',
            'notes' => $request->notes,
            'created_by' => Auth::id()
        ]);

        $slot->update([
            'status' => 'reserved'
        ]);

        return new AppointmentResource($appointment);
    }

    // Ver todas las citas
    public function index()
    {
        $appointments = Appointment::with([
            'pet',
            'service',
            'timeSlot'
        ])->get();

        return AppointmentResource::collection($appointments);
    }

    // Ver una cita
    public function show($id)
    {
        $appointment = Appointment::with([
            'pet',
            'service',
            'timeSlot'
        ])->findOrFail($id);

        return new AppointmentResource($appointment);
    }

    // Reagendar cita
    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $newSlot = TimeSlot::findOrFail($request->time_slot_id);

        if ($newSlot->status === 'reserved') {
            return response()->json([
                'message' => 'Horario ocupado'
            ], 400);
        }

        $oldSlot = TimeSlot::findOrFail($appointment->time_slot_id);

        // Liberar slot viejo
        $oldSlot->update([
            'status' => 'available'
        ]);

        // Reservar slot nuevo
        $newSlot->update([
            'status' => 'reserved'
        ]);

        $appointment->update([
            'time_slot_id' => $request->time_slot_id
        ]);

        return new AppointmentResource($appointment);
    }

    // Cancelar cita
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $slot = TimeSlot::findOrFail($appointment->time_slot_id);

        $slot->update([
            'status' => 'available'
        ]);

        $appointment->delete();

        return response()->json([
            'message' => 'Cita cancelada correctamente'
        ]);
    }
}
