<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;

class PetController extends Controller
{
    // Mostrar todas las mascotas con buscador opcional
    public function index(Request $request)
    {
        $query = Pet::query();

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return response()->json(PetResource::collection($query->get()));
    }

    // Mostrar una mascota
    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return response()->json(new PetResource($pet));
    }

    // Crear nueva mascota
    public function store(PetRequest $request)
    {
        $data = $request->validated();

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
        $pet = Pet::findOrFail($id);

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
        $pet = Pet::findOrFail($id);

        if ($pet->photo_path) {
            Storage::delete('public/' . $pet->photo_path);
        }

        $pet->delete();

        return response()->json(['message' => 'Mascota eliminada exitosamente']);
    }
}
