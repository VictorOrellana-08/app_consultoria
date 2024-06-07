<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de ventas</title>
    <style>
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .header,
        .footer,
        .table-items {
            width: 100%;
        }

        .header img {
            width: 100%;
            max-width: 100px;
        }

        .table-items th,
        .table-items td {
            text-align: center;
        }

        .text-company {
            font-size: 16px;
        }

        body {
            position: relative;
            padding-bottom: 60px;
            /* Espacio para el footer */
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            /* Altura del footer */
            text-align: center;
            line-height: 50px;
            /* Centrar el texto verticalmente */
        }

        .table-items th {
            background-color: #2e2e2e;
            /* Color azul oscuro */
            color: white;
            padding: 8px;
        }

        .table-items td {
            padding: 8px;
        }

        .table-items tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Color para las filas pares */
        }

        .table-items tr:nth-child(odd) {
            background-color: white;
            /* Color para las filas impares */
        }
    </style>
</head>

<body>
    <section class="header" style="margin-top: -20px;">
        <table class="header">
            <tr>
                <td colspan="2" class="text-center" style="font-size: 25px; font-weight: bold;">Reporte de ventas</td>
            </tr>
            <tr>
                <td width="30%">
                    <img src="{{ public_path('assets/img/logo_solumaq.png') }}" alt="Invoice Logo"
                        class="invoice-logo">
                </td>
                <td width="70%" class="text-left text-company">
                    @if ($reportType == 0)
                        <strong>Informe de ventas de hoy</strong>
                    @else
                        <strong>Informe por fecha</strong>
                    @endif
                    <br>
                    @if ($reportType != 0)
                        <strong>Consultar fecha: {{ $dateFrom }} to {{ $dateTo }}</strong>
                    @else
                        <strong>Consultar fecha: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong>
                    @endif
                    <br>
                    Usuario: {{ $user }}
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: 10px;">
        <table class="table-items">
            <thead>
                <tr>
                    <th width="10%">Factura</th>
                    <th width="12%">Importe</th>
                    <th width="10%">Items</th>
                    <th width="12%">Estatus</th>
                    <th>Usuarios</th>
                    <th width="18%">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                        <td>{{ $item->items }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->user }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><strong>{{ number_format($data->sum('total'), 2) }}</strong></td>
                    <td>{{ $data->sum('items') }}</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="footer">
        <table class="table-items">
            <tr>
                <td width="20%">Solumaq</td>
                <td width="60%" class="text-center">Ventas</td>
                <td width="20%" class="text-center">Pagina <span class="pagenum"></span></td>
            </tr>
        </table>
    </section>
</body>

</html>