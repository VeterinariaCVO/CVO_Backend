<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json([
            'users' => UserResource::collection($users)
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id'  => 'required|in:2,3',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'active'   => 'boolean',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['active']   = $data['active'] ?? true;

        $user = User::create($data);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user'    => new UserResource($user->load('role'))
        ], 201);
    }

    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|in:2,3',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'active'  => 'nullable|boolean',
        ]);

        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user'    => new UserResource($user->load('role'))
    ]);
    }   

    // Listar solo clientes
    public function clients()
    {
        $clients = User::with('role')->where('role_id', 3)->get();
        return response()->json([
            'clients' => UserResource::collection($clients)
        ]);
    }   

    // Ver cliente con sus mascotas
    public function showClient(string $id)
    {
        $client = User::with(['role', 'pets'])->findOrFail($id);
        return response()->json([
            'client' => new UserResource($client),
            'pets'   => $client->pets
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}