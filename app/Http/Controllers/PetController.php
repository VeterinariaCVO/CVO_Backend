<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    // Lista de mascotas (vista homecliente)
    public function index()
    {
        $pets = Pet::where('owner_id', Auth::id())->get();


        //vista anterior proyecto en blade: return view('cliente.homecliente', compact('pets'));

        //ahora tendra q mandarse en una peticion en api a vue front
    }

    // Formulario para agregar del anterior proyecto
    public function create()
    {
        // 
        //vista anterior proyecto en blade: return view('cliente.registro_mascota');
    }

    // Guardar nueva mascota
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'color' => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'sex' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png|max:5000', // Max 5MB
            'active'   => 'nullable|boolean'

        ]);

        //$data['owner_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        Pet::create($data);

        //vista anterior proyecto en blade: return redirect()->route('cliente.homecliente')->with('success', 'Mascota registrada exitosamente.');
    }

    // Ver detalle de mascota
    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }

        // vista anterior proyecto en blade:return view('cliente.info_mascota', compact('pet'));
    }

    // Formulario editar
    public function edit($id)
    {
        //esto sirve para 
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }
        //vista anterior proyecto en blade: return view('cliente.editar_mascota', compact('pet'));
    }

    // Actualizar mascota
    public function update(Request $request, $id)
    {
        
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'color' => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'sex' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png|max:5000',
            'active'   => 'nullable|boolean'
        ]);

        if ($request->hasFile('photo')) {
            
            if ($pet->photo_path) {
                Storage::delete('public/' . $pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        //vista anterior proyecto en blade: return redirect()->route('pets.show', $id)->with('success', 'Mascota actualizada exitosamente.');
    }

    // Borrar mascota
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }

        if ($pet->photo_path) {
            Storage::delete('public/' . $pet->photo_path);
        }

        $pet->delete();

         //vista anterior proyecto en blade: return redirect()->route('cliente.homecliente')->with('success', 'Mascota borrada exitosamente.');
    }

    //--------------------------- API para móvil-----------------------------------
    /*public function apiIndex()
    {

        
        $pets = Pet::all(); // Quita el where para básico – ahora retorna todo
    return response()->json($pets);
        /*
        $pets = Pet::where('owner_id', Auth::id())->get();
        return response()->json($pets);
    }*/
/*  



-------------------------API Anterior-----------------------------------------



    public function apiIndex(Request $request) 
{
    $userId = $request->query('user_id');
    $pets = $userId ? Pet::where('owner_id', $userId)->get() : Pet::all(); 
    return response()->json($pets);
}
public function apiStore(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'species' => 'required|string',
        'sex' => 'required|in:male,female',
        
    ]);
    $data['owner_id'] = 1; 
    Pet::create($data);
    return response()->json(['message' => 'Mascota agregada'], 201);
}
    
public function apiBySex($sex)
{
    $pets = Pet::where('sex', $sex)->get();
    return response()->json($pets);
}*/
// Listar mascotas (con filtro opcional por sexo)
    public function apiIndex(Request $request)
    {
        $query = Pet::query();

        if ($request->has('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->has('user_id')) {
            $query->where('owner_id', $request->user_id);
        }

        return response()->json($query->get());
    }

    // Crear nueva mascota
    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => 'required|in:male,female',
            'owner_id' => 'required|integer'
        ]);

        $pet = Pet::create($data);

        return response()->json([
            'message' => 'Mascota creada exitosamente',
            'pet' => $pet
        ], 201);
    }





}
