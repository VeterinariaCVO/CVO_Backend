<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pet_id' => 'required|exists:pets,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'service' => 'required|in:medical,daycare,surgery,vaccination',
            'notes' => 'nullable|string|max:255'
        ];
    }
}