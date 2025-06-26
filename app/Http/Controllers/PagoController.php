<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PagoController extends Controller
{
    public function response(Request $request)
    {
        $ref_payco = $request->input('ref_payco');
        return view('modules.dashboard.auth.response', compact('ref_payco'));
    }

    public function confirmation()
    {
        $ref_payco = request()->input('ref_payco');           // código único de referencia, consultar detalles pago
        
        Log::info("=== INICIO WEBHOOK CONFIRMATION ===");
        Log::info("ref_payco recibido: $ref_payco");

        // Hacer consulta a la API de ePayco para obtener los detalles del pago
        $response = Http::get("https://secure.epayco.co/validation/v1/reference/$ref_payco");

        if ($response->ok()) {             // Verificar si la respuesta es exitosa
            $data = $response->json();
            Log::info("Respuesta de ePayco:", $data);

            $x_response = $data['data']['x_response'];
            $x_transaction_id = $data['data']['x_transaction_id'];
            $x_amount = $data['data']['x_amount'];
            $x_currency_code = $data['data']['x_currency_code'];
            $x_customer_email = $data['data']['x_customer_email'];

            Log::info("Estado del pago: $x_response");
            Log::info("Email del cliente: $x_customer_email");

            // Guardar la orden si fue APROBADA
            if ($x_response == 'Aceptada') {
                
                // Buscar el usuario por email
                $user = \App\Models\User::where('email', $x_customer_email)->first();
                Log::info("Usuario encontrado: " . ($user ? "Sí (ID: {$user->id})" : "No"));
                
                // Crear la orden
                $order = \App\Models\Order::create([
                    'user_id' => $user ? $user->id : null,
                    'transaction_id' => $x_transaction_id,
                    'amount' => $x_amount,
                    'currency' => $x_currency_code,
                    'email' => $x_customer_email,
                    'status' => $x_response,
                ]);
                if ($user) {
                        $cart = \App\Models\Cart::where('user_id', $user->id)->first();

                        if ($cart) {
                            $cartItems = \App\Models\CartItem::where('cart_id', $cart->id)->get();

                            foreach ($cartItems as $item) {
                            \App\Models\Order::create([
                                    'user_id' => $user ? $user->id : null,
                                    'transaction_id' => $x_transaction_id,
                                    'amount' => $x_amount,
                                    'currency' => $x_currency_code,
                                    'email' => $x_customer_email,
                                    'status' => $x_response,
                                ]);
                            }
                        }
                        
                    }

                Log::info("Orden creada con ID: {$order->id}");

                // ✅ LIMPIAR EL CARRITO del usuario
                if ($user) {
                    // Verificar si el usuario tiene carrito antes de limpiar
                    $cart = \App\Models\Cart::where('user_id', $user->id)->first();
                    Log::info("Carrito del usuario: " . ($cart ? "Existe (ID: {$cart->id})" : "No existe"));
                    
                    if ($cart) {
                        $itemsCount = \App\Models\CartItem::where('cart_id', $cart->id)->count();
                        Log::info("Items en el carrito antes de limpiar: $itemsCount");
                    }
                    
                    $cleared = $this->clearUserCart($user->id);
                    Log::info("Resultado de limpieza: " . ($cleared ? "Exitoso" : "Falló"));
                } else {
                    Log::warning("No se encontró usuario con email: $x_customer_email");
                }

                Log::info("Pago confirmado. Transacción: $x_transaction_id");
            } else {
                Log::info("Pago no aceptado. Estado: $x_response");
            }

        } else {
            Log::error("Fallo al consultar a ePayco con ref_payco: $ref_payco");
            Log::error("Código de respuesta HTTP: " . $response->status());
        }

        Log::info("=== FIN WEBHOOK CONFIRMATION ===");
        return response('OK', 200); // ePayco requiere una respuesta 200
    }

    /**
     * Limpiar carrito del usuario desde la base de datos
     */
    private function clearUserCart($userId)
    {
        try {
            // Obtener el carrito del usuario
            $cart = \App\Models\Cart::where('user_id', $userId)->first();
            
            if ($cart) {
                // Eliminar todos los items del carrito
                \App\Models\CartItem::where('cart_id', $cart->id)->delete();
                
                Log::info("Carrito limpiado exitosamente para usuario ID: $userId");
                return true;
            } else {
                Log::info("No se encontró carrito para usuario ID: $userId");
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error al limpiar carrito para usuario ID: $userId - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Método para limpiar el carrito desde el frontend después del pago
     * (Método alternativo - el webhook ya debería haber limpiado el carrito)
     */


    /**
     * Método alternativo: verificar estado del pago
     */
    public function checkPaymentStatus(Request $request)
    {
        $ref_payco = $request->input('ref_payco');      //valor de ref_payco
        
        $response = Http::get("https://secure.epayco.co/validation/v1/reference/$ref_payco");       //información de la transacción
        
        if ($response->ok()) {
            $data = $response->json();
            return response()->json([
                'success' => true,
                'payment_status' => $data['data']['x_response'],
                'transaction_id' => $data['data']['x_transaction_id']
            ]);
        }
        
        return response()->json(['success' => false]);
    }
}