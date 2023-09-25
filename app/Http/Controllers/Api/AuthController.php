<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // Registro
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

    // Iniciar sesión
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

    // Perfil de usuario
    public function userProfile(Request $request)
    {
        return response()->json([
            "message" => "Perfil de usuario",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }

    // Cerrar sesión
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

}
