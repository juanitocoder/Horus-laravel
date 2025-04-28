<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PerfilController extends Controller
{
    public function editar()
    {
        return view('modules.dashboard.auth.perfil');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:6',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Siempre hashear
        }

        $user->save();

        return redirect()->route('perfil.editar')->with('success', 'Perfil actualizado correctamente.');
    }
}
