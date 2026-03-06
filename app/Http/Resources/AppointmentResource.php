<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Appointment */
class AppointmentResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'pet_id' => $this->pet_id,
            'service_id' => $this->service_id,
            'block_id' => $this->block_id,
            'date' => $this->date,
            'reason' => $this->reason,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
