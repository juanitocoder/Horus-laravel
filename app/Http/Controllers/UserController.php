<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('perfil')->with('success', 'Nombre actualizado correctamente.');
    }
}
