<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas</title>
    <!-- Agrega tus estilos CSS y librerías aquí -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row sales layout-top-spacing">
            <div class="col-sm-12">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h4 class="card-title">
                            <b>Facturas | Gestión</b>
                        </h4>
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="widget-content">
                        <form wire:submit.prevent="submit">
                            <div class="form-group">
                                <label for="razon_social">Razón Social</label>
                                <input type="text" id="razon_social" class="form-control" wire:model="razon_social">
                                @error('razon_social') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="nit">NIT</label>
                                <input type="text" id="nit" class="form-control" wire:model="nit">
                                @error('nit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="ncr">NCR</label>
                                <input type="text" id="ncr" class="form-control" wire:model="ncr">
                                @error('ncr') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="actividad_economica">Actividad Económica</label>
                                <input type="text" id="actividad_economica" class="form-control"
                                    wire:model="actividad_economica">
                                @error('actividad_economica') <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nombre_comercial">Nombre Comercial</label>
                                <input type="text" id="nombre_comercial" class="form-control"
                                    wire:model="nombre_comercial">
                                @error('nombre_comercial') <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" id="direccion" class="form-control" wire:model="direccion">
                                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" id="telefono" class="form-control" wire:model="telefono">
                                @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" id="correo" class="form-control" wire:model="correo">
                                @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea id="observaciones" class="form-control" wire:model="observaciones"></textarea>
                                @error('observaciones') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Crear Factura</button>
                        </form>
                    </div>

                    <div class="widget-content mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C;">
                                    <tr>
                                        <th class="table-th text-white">Razón Social</th>
                                        <th class="table-th text-white">NIT</th>
                                        <th class="table-th text-white">NCR</th>
                                        <th class="table-th text-white">Actividad Económica</th>
                                        <th class="table-th text-white">Nombre Comercial</th>
                                        <th class="table-th text-white">Dirección</th>
                                        <th class="table-th text-white">Teléfono</th>
                                        <th class="table-th text-white">Correo</th>
                                        <th class="table-th text-white">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($facturas as $factura)
                                    <tr>
                                        <td>{{ $factura->razon_social }}</td>
                                        <td>{{ $factura->nit }}</td>
                                        <td>{{ $factura->ncr }}</td>
                                        <td>{{ $factura->actividad_economica }}</td>
                                        <td>{{ $factura->nombre_comercial }}</td>
                                        <td>{{ $factura->direccion }}</td>
                                        <td>{{ $factura->telefono }}</td>
                                        <td>{{ $factura->correo }}</td>
                                        <td>{{ $factura->observaciones }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $facturas->links() }}
                        </div>
                    </div>


<div class="d-flex justify-content-center mt-4">
    <!-- Botón para ver el reporte de facturas en formato 'facturasReport.pdf' -->
    <a href="{{ route('facturas.pdf') }}" class="tbn btn-outline-success btn-lg mx-2">CREDITO FISCAL</a>

    <!-- Botón para ver el reporte de facturas en formato 'factura.pdf' -->
    <a href="{{ route('factura.pdf') }}" class="btn btn-outline-success btn-lg mx-2">CONSUMIDOR FINAL</a>
</div>


                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap y cualquier otro script necesario -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
