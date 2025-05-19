<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function perfil()
    {
        $user = Auth::user();
        return view('modules.dashboard.auth.perfil', compact('user'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);

        $user = \App\Models\User::find(Auth::id());
        if ($user) {
            $user->name = $request->input('name');
            $user->save();
        }

        return redirect()->route('perfil')->with('alert', 'Nombre actualizado correctamente.');
    }

            public function index()
            {
                $usuarios = User::where('id', '!=', auth()->id())->get(); // No se muestra a sí mismo
                $roles = Role::all();
                return view('modules.dashboard.auth.superadmin', compact('usuarios', 'roles'));
            }

        public function cambiarRol(Request $request, User $user)
            {
                $request->validate([
                    'role_id' => 'required|exists:roles,id'
                ]);

                $user->role_id = $request->role_id;
                $user->save();

                return redirect()->back()->with('alert', 'Rol actualizado correctamente.');
            }
}
