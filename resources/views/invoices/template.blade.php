{{-- resources/views/invoices/template.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Orden #{{ $orden->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            border-bottom: 3px solid #EAB308;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .logo-area h1 {
            font-size: 32px;
            color: #EAB308;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .logo-area p {
            color: #666;
            font-size: 14px;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-info h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .invoice-info p {
            margin-bottom: 5px;
            color: #666;
        }
        
        .company-info, .customer-info {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        
        .customer-info {
            margin-left: 4%;
        }
        
        .info-section h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #EAB308;
            padding-bottom: 5px;
        }
        
        .info-section p {
            margin-bottom: 5px;
            color: #666;
        }
        
        .order-details {
            margin: 30px 0;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .order-details h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-completada, .status-aceptada {
            background-color: #EAB308;
            color: #000;
        }
        
        .status-pendiente {
            background-color: #f59e0b;
            color: #fff;
        }
        
        .status-rechazada, .status-cancelada {
            background-color: #ef4444;
            color: #fff;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .items-table th {
            background-color: #333;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        
        .total-row {
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .total-final {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            border-top: 2px solid #EAB308;
            padding-top: 10px;
            margin-top: 15px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        
        .thank-you {
            background-color: #f0f9ff;
            border-left: 4px solid #EAB308;
            padding: 15px;
            margin: 30px 0;
        }
        
        .thank-you h4 {
            color: #333;
            margin-bottom: 5px;
        }
        
        .thank-you p {
            color: #666;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo-area">
                    <h1>HORUS</h1>
                    <p>Pulseras Artesanales Únicas</p>
                </div>
                <div class="invoice-info">
                    <h2>FACTURA</h2>
                    <p><strong>Número:</strong> #{{ str_pad($orden->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y') }}</p>
                    <p><strong>Generada:</strong> {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Company and Customer Info -->
        <div style="margin-bottom: 30px;">
            <div class="company-info info-section">
                <h3>Información de la Empresa</h3>
                <p><strong>{{ $empresa['nombre'] }}</strong></p>
                <p>{{ $empresa['direccion'] }}</p>
                <p>Tel: {{ $empresa['telefono'] }}</p>
                <p>Email: {{ $empresa['email'] }}</p>
                @if(isset($empresa['nit']))
                <p>NIT: {{ $empresa['nit'] }}</p>
                @endif
            </div>

            <div class="customer-info info-section">
                <h3>Información del Cliente</h3>
                <p><strong>{{ $orden->user->name }}</strong></p>
                <p>Email: {{ $orden->user->email }}</p>
                @if($orden->telefono)
                <p>Tel: {{ $orden->telefono }}</p>
                @endif
                @if($orden->direccion_envio)
                <p>Dirección: {{ $orden->direccion_envio }}</p>
                @endif
            </div>
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <h3>Detalles de la Orden</h3>
            <p><strong>Estado:</strong> <span class="status-badge status-{{ $orden->status }}">{{ ucfirst($orden->status) }}</span></p>
            <p><strong>Fecha de pedido:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
            @if($orden->notas)
            <p><strong>Notas:</strong> {{ $orden->notas }}</p>
            @endif
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($orden->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product->name }}</strong>
                        @if($item->product->description)
                        <br><small style="color: #666;">{{ Str::limit($item->product->description, 60) }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->cantidad }}</td>
                    <td class="text-right">${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                    <td class="text-right">${{ number_format($item->precio_unitario * $item->cantidad, 0, ',', '.') }}</td>
                </tr>
                @php $subtotal += $item->precio_unitario * $item->cantidad; @endphp
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="total-section">
            <div class="total-row">
                <strong>Subtotal: ${{ number_format($subtotal, 0, ',', '.') }}</strong>
            </div>
            @if($subtotal != $orden->total)
            <div class="total-row">
                Descuentos/Ajustes: ${{ number_format($orden->total - $subtotal, 0, ',', '.') }}
            </div>
            @endif
            <div class="total-final">
                <strong>TOTAL: ${{ number_format($orden->total, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="thank-you">
            <h4>¡Gracias por tu compra!</h4>
            <p>Apreciamos tu confianza en nuestras pulseras artesanales. Cada pieza es creada con amor y dedicación para conectar emociones y realizar tu estilo personal.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Este documento es una factura generada automáticamente por el sistema de {{ $empresa['nombre'] }}</p>
            <p>Para cualquier consulta, contáctanos en {{ $empresa['email'] }} o {{ $empresa['telefono'] }}</p>
            <p style="margin-top: 10px;">Creamos pulseras artesanales únicas que conectan emociones y realizan tu estilo personal.</p>
        </div>
    </div>
</body>
</html>