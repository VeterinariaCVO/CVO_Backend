<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\EmpleadoUpdateRequest;

class EmpleadoController extends Controller
{
    use ApiResponse;

   
    public function profile()
    {
        $user = Auth::user();

        return $this->success(
            new UserResource($user),
            'Información actual'
        );
    }


    public function updateProfile(EmpleadoUpdateRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return $this->success(
            new UserResource($user),
            'Perfil actualizado correctamente'
        );
    }
}

