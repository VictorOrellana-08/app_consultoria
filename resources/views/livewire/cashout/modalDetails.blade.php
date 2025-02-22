<div wire:ignore.self id="themodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Sale details
                        {{-- @foreach ($sales as $sale)
                        #{{ $sale->id }}
                        @endforeach --}}
                    </b>
                </h5>
                <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <img src="img/x.png" height="20" width="20" alt=""> </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-center text-white">
                                    Producto
                                </th>
                                <th class="table-th text-center text-white">
                                    Cantidad.
                                </th>
                                <th class="table-th text-center text-white">
                                    Precio
                                </th>
                                <th class="table-th text-center text-white">
                                    Importe
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                {{-- dd($details) --}}
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $d->product }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>{{ $d->quantity }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>${{ number_format($d->price, 2) }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>${{ number_format($d->quantity * $d->price, 2) }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right">
                                <h6  class="text-primary text-center">TOTAL:</h6>
                            </td>
                            <td class="text-center">
                                @if ($details)
                                    <h6 class="text-primary">{{ $details->sum('quantity') }}</h6>
                                @endif
                            </td>
                            @if ($details)
                                @php $mytotal = 0; @endphp
                                @foreach ($details as $d)
                                    @php
                                        $mytotal += $d->quantity * $d->price;
                                    @endphp
                                @endforeach
                                <td></td>
                                <td class="text-center">
                                    <h6 class="text-primary"> {{ number_format($mytotal, 2) }}</h6>
                                </td>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
