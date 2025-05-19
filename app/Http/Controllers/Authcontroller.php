<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
class Authcontroller extends Controller
{
    public function login()
    {
        return view('modules/dashboard/auth/login');
    }

    public function home(){
        return view ('modules/dashboard/auth/home');
    }

    public function register()
    {
        return view('modules/dashboard/auth/registro');
    }

    public function registrar(Request $request) {
        $mensajes = [
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede tener más de :max caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo electrónico no es válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.string' => 'La contraseña debe ser texto',
            'password.min' => 'La contraseña debe tener al menos :min caracteres',
            'password.confirmed' => 'La confirmación de contraseña no coincide',
            'admin_code.required' => 'El código de administrador es obligatorio',
            'admin_code.in' => 'El código de administrador no es válido',
        ];
    
        // Validaciones básicas para todos los usuarios
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], $mensajes);
        
        // Validación específica para administradores
        if ($request->user_type === 'admin') {
            $request->validate([
                'admin_code' => 'required|in:' . env('ADMIN_SECRET_CODE'),
            ], $mensajes);
        }
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        // Asignación de rol basada en tipo de usuario y código de admin
        if ($request->user_type === 'admin' && $request->admin_code === env('ADMIN_SECRET_CODE')) {
            $adminRole = Role::where('name', 'admin')->first();
            $user->role_id = $adminRole->id;
        } else {
            $userRole = Role::where('name', 'user')->first();
            $user->role_id = $userRole->id;
        }
        
        $user->save();
        
        return redirect()->route('login')->with('alert', 'Usuario registrado correctamente');
    }

    //validar
    public function logear(request $request){
        $credentials = [
            'email' => $request->email,
            'password' =>($request->password),
        ];

        if (Auth::attempt($credentials)) {
            $nombre = Auth::user()->name; // obtenemos el nombre del usuario autenticado
            return to_route('home')->with('alert', "Hola $nombre, sesión iniciada.");
        } else {
            return back()->with('error', 'Usuario o contraseña incorrectos');
        }
    }

    public function logout(Request $request)
    {
    Auth::logout(); // Cierra la sesión del usuario

    $request->session()->invalidate(); // Invalida la sesión en el servidor
    $request->session()->regenerateToken(); // Regenera el token CSRF por seguridad

    return redirect()->route('home')->with('alert', 'Usuario deslogueado correctamente');
    }

}