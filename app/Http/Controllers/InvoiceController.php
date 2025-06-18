<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function downloadInvoice($orderId)
    {
        // Verificar que la orden pertenece al usuario autenticado
        $orden = Order::with(['items.product', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Datos para la vista de la factura
        $data = [
            'orden' => $orden,
            'empresa' => [
                'nombre' => 'Horus - Pulseras Artesanales',
                'direccion' => 'Ibagué - Tolima, Colombia',
                'telefono' => '302 385 1370',
                'email' => 'Horus@gmail.com',
                
            ],
            'fecha_generacion' => now()
        ];

        // Generar PDF
        $pdf = Pdf::loadView('invoices.template', $data);
        
        // Configurar el PDF
        $pdf->setPaper('a4', 'portrait');
        
        // Nombre del archivo
        $filename = "factura-orden-{$orden->id}.pdf";
        
        // Descargar el PDF
        return $pdf->download($filename);
    }
}
