<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Pet::query();

        if ($user->role_id === 3) {
            $query->where('owner_id', $user->id);
        }

        if ($request->has('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return response()->json(PetResource::collection($query->get()));
    }

    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return response()->json(new PetResource($pet));
    }

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

    public function update(PetRequest $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($pet->photo_path) {

                Storage::disk('public')->delete($pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return response()->json([
            'message' => 'Mascota actualizada exitosamente',
            'pet'     => new PetResource($pet)
        ]);
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->photo_path) {

            Storage::disk('public')->delete($pet->photo_path);
        }

        $pet->delete();

        return response()->json(['message' => 'Mascota eliminada exitosamente']);
    }
}
