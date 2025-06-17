<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function historial()
{
    $user = auth()->user();

    $ordenes = $user->orders()->with('items.product')->orderBy('created_at', 'desc')->get();

    return view('modules.dashboard.auth.historial', compact('ordenes'));
}
}
