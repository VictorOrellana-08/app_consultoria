<div class="row sales layout-top-spacing mt-4">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>


                        <button href="javascript:void(0)" type="button" data-bs-toggle="modal" class="btn btn-dark btn-lg"
                            wire:click="create" data-bs-target="#themodal">Agregar</button>

                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center mb-3">
                <input type="text" wire:model.live="searchengine" class="form-control" placeholder="Search...">

            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C;">
                            <tr>
                                <th class="table-th text-white text-center">DESCRIPCIÓN</th>
                                <th class="table-th text-white text-center">BARCODE</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicios as $servicio)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $servicio->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $servicio->barcode }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $servicio->price }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $servicio->image) }}" alt="example"
                                            height="70" width="80" class="rounded">
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            wire:click="Edit({{ $servicio->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @if ($servicio->count() < 1)
                                            <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                                wire:click="Delete({{ $servicio->id }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $servicios->links() }}

                </div>

            </div>
        </div>
    </div>
    @include('livewire.servicios.form')


    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('servicio-added', msg => {
                $('#themodal').modal('hide');

            })
            @this.on('servicio-updated', msg => {
                $('#themodal').modal('hide');
                //   noty(msg);

            })
            @this.on('servicio-deleted', msg => {

            })
            //  @this.on('hide-modal', msg => {
            //       $('#themodal').modal('hide');
            //   })
            @this.on('show-modal', msg => {
                $('#themodal').modal('show');
            })
            //  @this.on('hidden.bs.modal', msg => {
            //       $('.er').css('display', 'none');
            //   })
        });
    </script>

</div>
