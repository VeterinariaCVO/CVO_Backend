<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'role_id'    => $this->role_id,
            'role'       => $this->role?->description ?? null,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'active'     => $this->active,
            'created_at' => $this->created_at,
        ];
    }
}

//Que ya jaleeeeeeeeee D: