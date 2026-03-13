<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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

        return response()->json($query->get());
    }

    // Crear nueva mascota
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'species'       => 'required|string',
            'breed'         => 'nullable|string',
            'color'         => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight'        => 'nullable|numeric',
            'sex'           => 'required|in:male,female',
            'age'           => 'nullable|integer',
            'photo'         => 'nullable|image|mimes:jpeg,png|max:5000',
            'owner_id'      => 'required|integer',
            'active'        => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet = Pet::create($data);

        return response()->json(['message' => 'Mascota creada exitosamente', 'pet' => $pet], 201);
    }

    // Actualizar mascota
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'species'       => 'required|string',
            'breed'         => 'nullable|string',
            'color'         => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight'        => 'nullable|numeric',
            'sex'           => 'required|in:male,female',
            'age'           => 'nullable|integer',
            'photo'         => 'nullable|image|mimes:jpeg,png|max:5000',
            'active'        => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($pet->photo_path) {
                Storage::delete('public/' . $pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return response()->json(['message' => 'Mascota actualizada exitosamente', 'pet' => $pet]);
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
