<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;

class AppointmentController extends Controller
{
    // Sin restricciones, solo para probar vista
    public function index()
    {
        $appointments = Appointment::with([
            'pet.owner',
            'timeSlot.workingDay',
            'creator'
        ])->get();

        return AppointmentResource::collection($appointments);
    }
    /* Este es el bueno, tiene restricciones
    public function index()
    {
        $user = Auth::user();
        // Cliente
        if ($user->role_id === 3) {
            $appointments = Appointment::whereHas('pet', function ($query) use ($user) {
                $query->where('client_id', $user->id);
            })->with([
                    'pet.client',
                    'timeSlot.workingDay',
                    'creator'
                ])->get();
         } else {
            $appointments = Appointment::with([
                'pet.client',
                'timeSlot.workingDay',
                'creator'
            ])->get();
        }
        return AppointmentResource::collection($appointments);
    }
    */


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
            'time_slot_id' => $request->time_slot_id,
            'service' => $request->service,
            'status' => 'pending',
            'notes' => $request->notes,
            'created_by' => Auth::id()
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

        $newSlot = TimeSlot::findOrFail($request->time_slot_id);

        if ($newSlot->status === 'reserved') {
            return response()->json([
                'message' => 'Horario ocupado'
            ], 400);
        }

        $oldSlot = TimeSlot::findOrFail($appointment->time_slot_id);

        $oldSlot->update([
            'status' => 'available'
        ]);

        $newSlot->update([
            'status' => 'reserved'
        ]);

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
