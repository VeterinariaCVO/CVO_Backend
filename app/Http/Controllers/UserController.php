<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function create(Request $request){
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
        'role_id' => 'required|exists:roles,id',
        'active' => 'required|boolean',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);

    $data['password'] = Hash::make($data['password']);

    $user = User::create($data);

    return response()->json([
        "message" => "Usuario registrado correctamente",
        "user" => $user
    ],201);

    }
    public function index(Request $request)
    {
    $query = DB::table('users')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->select(
            'users.id',
            'users.name',
            'users.email',
            'users.phone',
            'users.address',
            'users.active',
            DB::raw('roles.description as role'),
            DB::raw("CASE
            WHEN users.active = 1 THEN 'Active'
            ELSE 'Inactivo'
            END as status")
        )
        ->where('roles.description', 'client');

    if ($request->search) {
        $query->where('users.name', 'like', '%' . $request->search . '%');
    }

    $clients = $query->get();

    return response()->json($clients);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'active' => 'required|boolean',
    ]);

    $user = User::findOrFail($id);
    $user->update($data);

    return response()->json([
        'message' => 'Cliente actualizado correctamente',
        'user' => $user
    ]);
    }

    public function destroy(string $id)
    {
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json([
        'message' => 'Cliente eliminado correctamente'
    ]);
    }
}
