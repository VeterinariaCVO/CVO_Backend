<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pet_id' => $this->pet_id,
            'service_id' => $this->service_id,
            'time_slot_id' => $this->time_slot_id,
            'status' => $this->status,
            'notes' => $this->notes
        ];
    }
}
