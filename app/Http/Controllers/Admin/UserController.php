<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        // Obtenemos todos los usuarios y los paginamos
        $users = User::latest()->paginate(15);
        
        // Devolvemos la vista y le pasamos los usuarios
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,user'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Creamos el nuevo usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        // Redirigimos a la lista con un mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra los detalles de un usuario específico.
     * (Lo dejaremos simple por ahora)
     */
    public function show(User $user)
    {
        // Podrías crear una vista de 'show' si necesitas ver más detalles
         return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza los datos de un usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        // Validamos los datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string', 'in:admin,user'],
            'is_active' => ['required', 'boolean'],
            // La contraseña es opcional al editar
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Actualizamos los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_active = $request->is_active;

        // Solo actualizamos la contraseña si el campo no está vacío
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        // Opcional: añadir una comprobación para no poder eliminar al propio usuario admin
         if ($user->id === Auth::id()) {
        return back()->with('error', 'No puedes eliminar tu propio usuario.');
    }

        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}