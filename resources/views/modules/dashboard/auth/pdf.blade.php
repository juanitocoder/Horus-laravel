<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #000;
            font-size: 12px;
            margin: 30px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .line {
            display: flex;
            justify-content: space-between;
        }
        .bold {
            font-weight: bold;
        }
        .divider {
            border-top: 1px solid #000;
            margin: 10px 0;
        }
        
    </style>
</head>
<body>


    

    <div class="header">
        <h2>FACTURA</h2>
        <div class="bold">Factura</div>
        <div>Fecha: {{ $factura->created_at->format('d/m/Y') }}</div>
    </div>

    <div class="section">
        <div class="bold">Datos del Cliente:</div>
        <div>Nombre: {{ $factura->user->name }}</div>
        <div>Correo: {{ $factura->user->email }}</div>
    </div>

    <div class="section">
        <div class="bold">Detalle de productos:</div>
        <div class="divider"></div>

        @foreach($factura->detalles as $detalle)
            <div class="line">
                <div>{{ $detalle->product->nombre }}</div>
                <div>Cantidad: {{ $detalle->cantidad }}</div>
                <div>Precio: ${{ number_format($detalle->precio_unitario, 2) }}</div>
                <div>Subtotal: ${{ number_format($detalle->subtotal, 2) }}</div>
            </div>
        @endforeach

        <div class="divider"></div>
    </div>

    <div class="section">
        <div class="line">
            <div class="bold">Total:</div>
            <div class="bold">${{ number_format($factura->total, 2) }}</div>
        </div>
    </div>

    <div class="footer">
        <div>Gracias por su compra!</div>
    </div>

</body>
</html>
