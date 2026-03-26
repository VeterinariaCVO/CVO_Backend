<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8',
            'role_id'       => 'required|in:2,3',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'active'        => 'boolean',
            'gender'        => 'nullable|in:masculino,femenino,otro',
            'birth_date'    => 'nullable|date|before:-18 years',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['active']   = $data['active'] ?? true;

        // Subir foto si viene
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')
                ->store('profile_photos', 'public');
        }

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
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id'       => 'required|exists:roles,id',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'active'        => 'nullable|boolean',
            // Campos nuevos CU-09
            'gender'        => 'nullable|in:masculino,femenino,otro',
            'birth_date'    => 'nullable|date|before:-18 years',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Subir nueva foto (elimina la anterior)
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')
                ->store('profile_photos', 'public');
        }

        // Eliminar foto sin reemplazar
        if ($request->input('remove_photo') == '1') {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = null;
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

    // Listar solo empleados
    public function employees()
    {
        $employees = User::with('role')->where('role_id', 2)->get();
        return response()->json([
            'employees' => UserResource::collection($employees)
        ]);
    }

    // Ver empleado especifico
    public function showEmployee(string $id)
    {
        $employee = User::with('role')->where('role_id', 2)->findOrFail($id);
        return response()->json([
            'employee' => new UserResource($employee)
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Eliminar foto si existe
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ]);
    }

    public function updatePerfil(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'phone'    => 'sometimes|string|max:20',
            'address'  => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:4',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user'    => new UserResource($user)
        ]);
    }
    public function destroyPerfil()
    {
        $user = Auth::user();
        $user->delete();

        return response()->json([
            'message' => 'Cuenta eliminada correctamente'
        ]);
    }
}
