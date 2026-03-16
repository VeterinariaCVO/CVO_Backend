<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\PetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;

class PetController extends Controller
{
    // Mostrar mascotas (admin y empleado ven todas, cliente solo las suyas)
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = in_array($user->role_id, [1, 2])
            ? Pet::query()
            : Pet::where('owner_id', $user->id);

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return response()->json(PetResource::collection($query->get()));
    }

    // Ver una mascota
    public function show($id)
    {
        $user = auth()->user();

        $pet = in_array($user->role_id, [1, 2])
            ? Pet::findOrFail($id)
            : Pet::where('id', $id)->where('owner_id', $user->id)->firstOrFail();

        return response()->json(new PetResource($pet));
    }

    // Crear mascota (admin y empleado asignan owner_id, cliente se asigna solo)
    public function store(PetRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        if (!in_array($user->role_id, [1, 2])) {
            $data['owner_id'] = $user->id;
        }

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet = Pet::create($data);

        return response()->json([
            'message' => 'Mascota creada exitosamente',
            'pet'     => new PetResource($pet)
        ], 201);
    }

    // Actualizar mascota
    public function update(PetRequest $request, $id)
    {
        $user = auth()->user();

        $pet = in_array($user->role_id, [1, 2])
            ? Pet::findOrFail($id)
            : Pet::where('id', $id)->where('owner_id', $user->id)->firstOrFail();

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($pet->photo_path) {
                Storage::delete('public/' . $pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return response()->json([
            'message' => 'Mascota actualizada exitosamente',
            'pet'     => new PetResource($pet)
        ]);
    }

    // Eliminar mascota
    public function destroy($id)
    {
        $user = auth()->user();

        $pet = in_array($user->role_id, [1, 2])
            ? Pet::findOrFail($id)
            : Pet::where('id', $id)->where('owner_id', $user->id)->firstOrFail();

        if ($pet->photo_path) {
            Storage::delete('public/' . $pet->photo_path);
        }

        $pet->delete();

        return response()->json(['message' => 'Mascota eliminada exitosamente']);
    }
}
