<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center">
                    <b>{{ $componentName }}</b>
                </h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">

                        <div class="col-sm-12">
                            <h6>Elige usuario</h6>
                            <div class="form-group">
                                <select wire:model.live='userId' class="form-control">
                                    <option value="0">Todos</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-2">
                            <h6>Elija el tipo de informe</h6>
                            <div class="form-group">
                                <select wire:model.live='reportType' class="form-control">
                                    <option value="0">Ventas de hoy</option>
                                    <option value="1">Ventas por fecha</option>

                                </select>
                            </div>
                        </div>

                        @if ($reportType == 1)
                            <div class="col-sm-12 mt-2">
                                <h6>Partir de la fecha</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr"
                                        placeholder="Haga clic para elegir">
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <h6>Hasta la fecha</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr"
                                        placeholder="Haga clic para elegir">
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-12 mt-2">
                            {{-- <button wire:click='$refresh' class="btn btn-darl btn-block">
                                Consult
                            </button> --}}

                            @if (count($data) < 1)
                                <a class="btn btn-dark btn-block disabled" href="#" target="_blank">Crear PDF</a>
                                <a class="btn btn-dark btn-block disabled" href="#" target="_blank">Exportar en
                                    Excel</a>
                            @else
                                <a class="btn btn-dark btn-block"
                                    href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                    target="_blank">Create PDF</a>
                                <a class="btn btn-dark btn-block"
                                    href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                    target="_blank">Export to Excel</a>
                            @endif
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-9">
                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C;">
                                    <tr>
                                        <th class="table-th text-white text-center">Folio</th>
                                        <th class="table-th text-white text-center">Total</th>
                                        <th class="table-th text-white text-center">Items</th>
                                        <th class="table-th text-white text-center">Estatus</th>
                                        <th class="table-th text-white text-center">Ususario</th>
                                        <th class="table-th text-white text-center">Fecha</th>
                                        <th class="table-th text-white text-center" width="50px"></th>

                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6>{{ $d->id }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ number_format($d->total, 2) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->items }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->status }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->user }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}
                                                </h6>
                                            </td>
                                            <td class="text-center" width="50px">
                                                <button wire:click.prevent="getDetails({{ $d->id }})"
                                                    class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                        @if (count($data) < 1)
                            <tr>
                                <td colspan="7">
                                    <p class="text-center">No hay resultados.</p>
                                </td>
                            </tr>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('livewire.reports.sales-detail')
</div>
<script>
    document.addEventListener('livewire:initialized', () => {

        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d'

        })

        @this.on('show-modal', msg => {
            $('#themodal').modal('show');
        })

    });
</script>
