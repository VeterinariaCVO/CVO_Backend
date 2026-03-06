<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'notes' => 'nullable|string|max:255'
        ];
    }
}
