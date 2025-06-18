<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {  
        return view('modules.dashboard/auth/home', compact('productos'));
    }

    
}
