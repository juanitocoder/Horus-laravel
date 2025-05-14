<?php

// Importación de controladores y utilidades necesarias
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

// ---------------------
// RUTAS PÚBLICAS GENERALES
// ---------------------

// Página principal (home)
Route::get('/', [HomeController::class, 'index']);

// Autenticación
Route::get('/login', [Authcontroller::class, 'login'])->name('login');
Route::get('/registro', [Authcontroller::class, 'register'])->name('registro');
Route::post('/registrar', [Authcontroller::class, 'registrar'])->name('registrar');
Route::post('/logear', [Authcontroller::class, 'logear'])->name('logear');
Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');

// Home protegido (aunque ya tienes el home sin auth arriba, podría estar duplicado)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ---------------------
// RUTAS DE PRODUCTOS
// ---------------------

// Productos por categoría
Route::get('/hombres', [ProductController::class, 'hombres'])->name('.hombres');
Route::get('/mujeres', [ProductController::class, 'mujeres'])->name('.mujeres');
Route::get('/parejas', [ProductController::class, 'parejas'])->name('.parejas');
Route::get('/promo', [ProductController::class, 'promo'])->name('promo');

// CRUD de productos (admin)
Route::delete('/producto/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/crear', [ProductController::class, 'create'])->name('product.create');
Route::post('/guardar', [ProductController::class, 'store'])->name('product.store');
Route::post('/calificar-producto/{id}', [ProductController::class, 'calificar']);

// ---------------------
// RUTAS CON MIDDLEWARE DE AUTENTICACIÓN (requieren login)
// ---------------------
Route::middleware(['auth'])->group(function () {

    // Ratings y perfil
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [UserController::class, 'actualizar'])->name('perfil.actualizar');

    // ADMIN (Aquí estaba el conflicto de graficas)
    // Solo debería quedar uno. Ejemplo:
    Route::get('/admin/graficas', [GraficaController::class, 'graficas'])->name('admin.graficas');
});

// ---------------------
// RUTAS DEL CARRITO CON MIDDLEWARE AUTH
// ---------------------
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CartController::class, 'show'])->name('cart.show');
    Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/carrito/eliminar/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/carrito/aumentar/{item}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/carrito/disminuir/{item}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/product/{product}', [ProductController::class, 'update'])->name('product.update');
});

// ---------------------
// RECUPERAR CONTRASEÑA
// ---------------------

// Mostrar formulario de recuperación de contraseña
Route::get('/olvide-password', function () {
    return view('modules.dashboard.auth.forgot-password');
})->name('password.request');

// Procesar solicitud y enviar enlace de restablecimiento
Route::post('/olvide-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    // Verifica existencia del usuario
    $user = \App\Models\User::where('email', $request->email)->first();
    if (!$user) {
        return back()->withErrors(['email' => 'No se encontró ningún usuario con ese correo.']);
    }

    // Genera token aleatorio
    $token = Str::random(64);

    // Guarda token en base de datos
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => Hash::make($token),
            'created_at' => now()
        ]
    );

    // Envía la notificación por email
    $user->notify(new \App\Notifications\PasswordResetNotification($token, $request->email));

    return back()->with('status', 'Te hemos enviado un correo con las instrucciones para restablecer tu contraseña.');
})->name('password.email');

// Vista para ingresar nueva contraseña
Route::get('/reset-password/{token}', function ($token, Request $request) {
    return view('modules.dashboard.auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email')
    ]);
})->name('password.reset');

// Procesar el restablecimiento de la contraseña
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Verifica token y correo
    $record = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    if (!$record || !Hash::check($request->token, $record->token)) {
        return back()->withErrors(['email' => ['El token es inválido o ha expirado.']]);
    }

    // Actualiza contraseña
    $user = \App\Models\User::where('email', $request->email)->first();
    if (!$user) {
        return back()->withErrors(['email' => ['No se encontró el usuario.']]);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Borra token usado
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return redirect('/login')->with('status', 'Contraseña restablecida con éxito.');
})->name('password.update');

// ---------------------
// PERFIL DEL USUARIO
// ---------------------
Route::get('/perfil', [PerfilController::class, 'editar'])->name('perfil.editar');
Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');

// ---------------------
// NOSOTROS (información estática)
// ---------------------
Route::view('/nosotros', 'modules.dashboard.auth.nosotros')->name('nosotros');

// ---------------------
// COMENTARIOS EN PRODUCTOS
// ---------------------
Route::get('/comentarios/producto/{id}', [CommentController::class, 'comentariosPorProducto']);
Route::post('/productos/{id}/comentarios', [CommentController::class, 'store']);
Route::put('/comentarios/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comentarios/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

// ---------------------
// ADMINISTRACIÓN DE COMENTARIOS (solo admin)
// ---------------------
Route::get('/admin/comentarios', [CommentController::class, 'vistaComentarios'])->name('admin.comentarios');
Route::delete('/admin/comentarios/{id}', [CommentController::class, 'destroyAdmin'])->name('admin.comentarios.eliminar');


