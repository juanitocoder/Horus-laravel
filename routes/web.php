<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GraficaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CheckoutController;



// Rutas principales
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [Authcontroller::class, 'login'])->name('login');
Route::get('/registro', [Authcontroller::class, 'register'])->name('registro');
Route::post('/registrar', [Authcontroller::class, 'registrar'])->name('registrar');
Route::post('/logear', [Authcontroller::class, 'logear'])->name('logear');
Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');


// Productos
Route::get('/hombres', [ProductController::class, 'hombres'])->name('.hombres');
Route::get('/mujeres', [ProductController::class, 'mujeres'])->name('.mujeres');
Route::get('/parejas', [ProductController::class, 'parejas'])->name('.parejas');
Route::get('/promo', [ProductController::class, 'promo'])->name('promo');

// Carrito
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/producto/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/crear', [ProductController::class, 'create'])->name('product.create');
Route::post('/guardar', [ProductController::class, 'store'])->name('product.store');
Route::post('/calificar-producto/{id}', [ProductController::class, 'calificar']);


Route::middleware(['auth'])->group(function () {
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [UserController::class, 'actualizar'])->name('perfil.actualizar');
    Route::get('/admin/graficas', [AdminController::class, 'graficas'])->name('admin.graficas')->middleware(['auth']);
    Route::get('/admin/graficas', [GraficaController::class, 'graficas'])->middleware('auth')->name('admin.graficas');
});



// Middleware auth para carrito
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CartController::class, 'show'])->name('cart.show');
    Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/carrito/eliminar/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/carrito/aumentar/{item}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/carrito/disminuir/{item}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/product/{product}', [ProductController::class, 'update'])->name('product.update');
});

// --- RECUPERAR CONTRASEÑA ---

// Mostrar formulario
Route::get('/olvide-password', function () {
    return view('modules.dashboard.auth.forgot-password');
})->name('password.request');

// Generar y mostrar enlace de restablecimiento
Route::post('/olvide-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    // Verifica si el usuario existe
    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No se encontró ningún usuario con ese correo.']);
    }

    // Crea token
    $token = Str::random(64);

    // Guarda en la base de datos
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => Hash::make($token),
            'created_at' => now()
        ]
    );

    // Envía el correo con el enlace
$user->notify(new \App\Notifications\PasswordResetNotification($token, $request->email));

return back()->with('status', 'Te hemos enviado un correo con las instrucciones para restablecer tu contraseña.');
})->name('password.email');

// Mostrar vista de restablecimiento
Route::get('/reset-password/{token}', function ($token, Request $request) {
    return view('modules.dashboard.auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email')
    ]);
})->name('password.reset');

// Procesar cambio de contraseña
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Busca el token
    $record = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    if (!$record || !Hash::check($request->token, $record->token)) {
        return back()->withErrors(['email' => ['El token es inválido o ha expirado.']]);
    }

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => ['No se encontró el usuario.']]);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Elimina el token
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return redirect('/login')->with('status', 'Contraseña restablecida con éxito.');
})->name('password.update');


//editar perfil
Route::get('/perfil', [PerfilController::class, 'editar'])->name('perfil.editar');
Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');

// Nosotroa
Route::view('/nosotros', 'modules.dashboard.auth.nosotros')->name('nosotros');


// Comentarios
Route::get('/comentarios/producto/{id}', [CommentController::class, 'comentariosPorProducto']);
Route::post('/productos/{id}/comentarios', [CommentController::class, 'store']);

Route::put('/comentarios/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comentarios/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Comentarios admin
Route::get('/admin/comentarios', [CommentController::class, 'vistaComentarios'])->name('admin.comentarios');
Route::delete('/admin/comentarios/{id}', [CommentController::class, 'destroyAdmin'])->name('admin.comentarios.eliminar');

//facturaccion
Route::post('/checkout', [CheckoutController::class, 'finalizarCompra'])->name('checkout.finalizar');
Route::get('/factura/{id}', [CheckoutController::class, 'verFactura'])->name('factura.ver');

//descargar pdf
Route::get('/pdf/{id}/pdf', [CheckoutController::class, 'descargarFactura'])->name('factura.pdf');




