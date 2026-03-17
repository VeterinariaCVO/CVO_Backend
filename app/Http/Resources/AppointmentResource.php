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
            'pet' => [
                'id' => $this->pet->id,
                'name' => $this->pet->name
            ],
            'client' => [
                'id' => $this->pet->owner->id,
                'name' => $this->pet->owner->name,
                'phone' => $this->pet->owner->phone
            ],
            'service' => $this->service,
            'time_slot' => [
                'date' => $this->timeSlot->workingDay->date,
                'start_time' => $this->timeSlot->start_time,
                'end_time' => $this->timeSlot->end_time
            ],
            'status' => $this->status,
            'notes' => $this->notes,
            'created_by' => $this->creator->name
        ];
    }
}
