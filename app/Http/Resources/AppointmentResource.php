<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'service' => $this->service,
            'status' => $this->status,

            'pet' => [
                'id' => $this->pet->id,
                'name' => $this->pet->name,
            ],

            'client' => [
                'id' => $this->pet->owner->id,
                'name' => $this->pet->owner->name,
                'phone' => $this->pet->owner->phone,
            ],

            'time_slot' => [
                'date' => $this->timeSlot->workingDay->date,
                'start_time' => $this->timeSlot->start_time,
                'end_time' => $this->timeSlot->end_time,
            ],
        ];
    }
}
