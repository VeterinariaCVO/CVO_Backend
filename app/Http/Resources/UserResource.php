<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'role_id'       => $this->role_id,
            'role'          => $this->role?->description ?? null,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'active'        => $this->active,
            'created_at'    => $this->created_at,
            'gender'        => $this->gender,
            'birth_date'    => $this->birth_date,
            'age'           => $this->birth_date ? \Carbon\Carbon::parse($this->birth_date)->age: null,
            'profile_photo' => $this->profile_photo ? Storage::url($this->profile_photo): null,
        ];
    }
}