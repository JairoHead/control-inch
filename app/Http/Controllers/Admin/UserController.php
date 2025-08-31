<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        // 1. Validamos los datos del formulario, incluyendo la foto opcional
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,user'],
            'is_active' => ['required', 'boolean'],
            'photo' => ['nullable', 'image', 'max:2048'], // Regla para la foto (2MB max)
        ]);

        // 2. Preparamos los datos para la creación del usuario
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'is_active' => $validatedData['is_active'],
        ];

        // 3. Si se subió una foto, la guardamos y añadimos la ruta a los datos
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $userData['profile_photo_path'] = $path;
        }

        // 4. Creamos el nuevo usuario con todos los datos
        User::create($userData);

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
        // 1. Validamos los datos, incluyendo la foto opcional
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string', 'in:admin,user'],
            'is_active' => ['required', 'boolean'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // 2. Si se subió una nueva foto
        if ($request->hasFile('photo')) {
            // Borramos la foto anterior, si existe
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Guardamos la nueva foto y obtenemos su ruta
            $path = $request->file('photo')->store('profile-photos', 'public');
            // Actualizamos la ruta en el modelo del usuario
            $user->profile_photo_path = $path;
        }

        // 3. Actualizamos los demás datos del usuario
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->is_active = $validatedData['is_active'];

        // Solo actualizamos la contraseña si el campo no está vacío
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // 4. Guardamos todos los cambios en la base de datos
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