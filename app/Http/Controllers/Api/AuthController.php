<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller

// ----------------------------- Registro ---------------------------------------------------

{
    public function register(Request $request)
    {
        //validación de los datos del registro
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        //alta del usuario
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = $request->password;
        $user->password = Hash::make($request->password); // metodo para cifrar pass
        $user->save();
        //respuesta
        // return response()->json([
        //     "message" => "Registro exitoso"
        // ]);
        return response(["message" => "Registro exitoso", $user], Response::HTTP_CREATED);
    }

// ----------------------------- Iniciar sesión ---------------------------------------------------

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token" => $token, "message" => "Inicio sesión exitosamente"], Response::HTTP_OK)->withoutCookie($cookie);
        } else {
            return response(["message" => "Usuario o Contraseña inválidos"], Response::HTTP_UNAUTHORIZED);
        }
    }

// ----------------------------------- Perfil de usuario ---------------------------------------------

    public function userProfile(Request $request)
    {
        return response()->json([
            "message" => "Perfil de usuario",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }

// ---------------------------------- Cerrar sesión ----------------------------------------------

    public function logout()
    {
        $cookie = Cookie::forget('cookie_token');
        return response(["message" => "Cierre de sesión exitoso"], Response::HTTP_OK)->withCookie($cookie);
    }

    // Mostrar todos los usuarios
    public function allUsers()
    {
        $users = User::all();
        return response()->json([
            "users" => $users
        ]);
    }

    // --------------------------------- Editar o actualizar usuario -----------------------------------------------

    public function editUser(Request $request, $id)
    {
        // Verifica si el usuario autenticado es el "kilber@admin.com" o si el ID coincide
        // (Solo el admin puede editar todos user y el user que se loguea puede editar unicamente su cuenta)

        $currentUser = Auth::user();

        if ($currentUser->email === 'kilber@admin.com' || $currentUser->id == $id) {
            // Busca el usuario por su ID
            $user = User::find($id);

            // Verifica si el usuario existe
            if (!$user) {
                return response(["message" => "El usuario no existe"], Response::HTTP_NOT_FOUND);
            }

            // Validación de los datos del formulario de edición
            $request->validate([
                'name' => 'sometimes', // Hace que el campo sea opcional
                'email' => [
                    'nullable', // Hace que el campo sea opcional
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
                'password' => 'sometimes|confirmed',
            ]);

            // Actualiza los datos del usuario
            $user->name = $request->input('name');
        
            if ($request->filled('email')) {
                $user->email = $request->input('email');
            }
    
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            return response(["message" => "Usuario actualizado exitosamente"], Response::HTTP_OK);
        } else {
            return response(["message" => "No tienes permiso para editar este usuario"], Response::HTTP_FORBIDDEN);
        }
    }

// ---------------------------------- Eliminar usuarios ----------------------------------------------

    public function deleteUser(Request $request, $id)
    {
        // Verifica si el usuario autenticado es el "kilber@admin.com" o si el ID coincide
        // (Solo el admin puede eliminar todos los user y el user que se loguea puede eliminar solo cuenta)

        $currentUser = Auth::user();

        if ($currentUser->email === 'kilber@admin.com' || $currentUser->id == $id) {
            // Busca el usuario por su ID
            $user = User::find($id);
    
            // Verifica si el usuario existe
            if (!$user) {
                return response(["message" => "El usuario no existe"], Response::HTTP_NOT_FOUND);
            }
    
            // Elimina el usuario
            $user->delete();
    
            // Cerrar la sesión del usuario si es el propio usuario autenticado
            if ($currentUser->id == $id) {
                Auth::logout();
                $cookie = Cookie::forget('cookie_token');
                return response(["message" => "Tu cuenta ha sido eliminada exitosamente"], Response::HTTP_OK)->withCookie($cookie);
            }
    
            return response(["message" => "Usuario eliminado exitosamente"], Response::HTTP_OK);
        } else {
            return response(["message" => "No tienes permiso para eliminar este usuario"], Response::HTTP_FORBIDDEN);
        }
    }

}
