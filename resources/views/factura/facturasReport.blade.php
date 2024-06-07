<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Facturas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .content {
            margin-bottom: 20px;
        }

        .emisor,
        .receptor {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .detalle {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .detalle th,
        .detalle td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        .bordered {
            border: 1px solid #ccc;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        .observaciones {
            margin-bottom: 20px;
        }

        .footer {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            font-size: 12px;
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        .container {
            width: 100%;
            min-height: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .content {
            overflow: hidden;
        }

        .emisor,
        .receptor,
        .bordered {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    @foreach($facturaciones as $factura)
    <div class="container">
        <div class="header">
            <img src="{{ public_path('assets/img/logo_solumaq.png') }}" alt="Logo">
            <h2>DOCUMENTO TRIBUTARIO ELECTRÓNICO</h2>
            <h3>COMPROBANTE DE CREDITO FISCAL</h3>
        </div>
        <div class="content">
            <div class="bordered">
                <p><strong>Código de generación:</strong> 125DF25D5SS854-BE5FF</p>
                <p><strong>Número de control:</strong> DTE-01-S001P007-00000000001</p>
                <p><strong>Sello de recepción:</strong> 2024A4KDHD136DJHMD4DYHR528</p>
                <p><strong>No-unico:</strong> 2013665</p>
                <p><strong>Modelo de facturación:</strong> Modelo de facturación previo.</p>
                <p><strong>Tipo de transmisión:</strong> Transmision normal.</p>
                <p><strong>Fecha y hora de generación:</strong> 03/06/2024 - 23:00 PM</p>
                <p><strong>Sucursal:</strong> Tienda A</p>
            </div>
            <div class="emisor">
                <h4>EMISOR</h4>
                <p><strong>Razón social:</strong> Soluciones De Maquinarias, S.A DE C.V.</p>
                <p><strong>NIT:</strong> 0614-010109-001-1</p>
                <p><strong>NCR:</strong> 1111111-1</p>
                <p><strong>Actividad económica:</strong> Servicios De Mecanica Automotriz Equipo pesado y
                    comercialización repuestos</p>
                <p><strong>Dirección:</strong> Av. Manuel Enrique Araujo 5-5 San Salvador, El Salvador</p>
                <p><strong>Número de teléfono:</strong> 2555-5555</p>
                <p><strong>Correo electrónico:</strong> solumaq@gmail.com</p>
            </div>

            <div class="receptor bordered">
                <h4>RECEPTOR</h4>
                <table class="detalle">
                    <thead>
                        <tr>
                            <th>Razón social</th>
                            <th>NIT</th>
                            <th>NCR</th>
                            <th>Actividad económica</th>
                            <th>Nombre comercial</th>
                            <th>Dirección</th>
                            <th>Número de teléfono</th>
                            <th>Correo electrónico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $factura->razon_social }}</td>
                            <td>{{ $factura->nit }}</td>
                            <td>{{ $factura->ncr }}</td>
                            <td>{{ $factura->actividad_economica }}</td>
                            <td>{{ $factura->nombre_comercial }}</td>
                            <td>{{ $factura->direccion }}</td>
                            <td>{{ $factura->telefono }}</td>
                            <td>{{ $factura->correo }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="receptor bordered">
                <h4>Montos de efectivos</h4>
                <table class="detalle">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Código</th>
                            <th>Efectivo recibido</th>
                            <th>Venta final (IVA incluido)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalVentasGravadas = 0;
                        @endphp
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->items }}</td>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->cash }}</td>
                            <td>{{ $sale->total }}</td>
                            @php
                                $totalVentasGravadas += $sale->total;
                            @endphp
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><strong>Total</strong></td>
                            <td><strong>{{ $totalVentasGravadas }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="bordered observaciones">
                <p><strong>OBSERVACIONES:</strong> {{ $factura->observaciones }}</p>
            </div>
            <div class="footer">
                <p>Sumas Operaciones: $ -</p>
                <p>Sub-Total: $ 250.25</p>
                <p>(-) IVA Percibido: $ -</p>
                <p>(-) IVA Retenido: $ -</p>
                <p>Retención Renta: $ -</p>
                <h3>Monto total operación: $ {{ $factura->total }}</h3>
                <p>Otros montos no afectos: $ -</p>
                <h3>Total a Pagar: $ {{ $factura->total }}</h3>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>
