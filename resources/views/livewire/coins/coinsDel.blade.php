<div wire:ignore.self id="delete" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><b>{{ $componentName }}</b> |
                    Delete</h5>
                <h6 class="text-center text-warning" wire:loading>Espere por favor...</h6>
            </div>
            <div class="modal-body">

                <div class="text-center text-white h3">¿Estás seguro de que quieres eliminar esta denominación?</div>
                <div class="">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="text-white" for="">Nombre</label>
                            <p class="form-control-static h4">{{ $value }}</p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="text-white" for="">Tipo</label>
                            <p class="form-control-static h4">{{ $type }}</p>
                        </div>
                    </div>
                </div>
                @if ($selected_id > 0 && !$image)
                    <img src="{{ asset('storage/' . $currentImage) }}" alt="example" height="70" width="80"
                        class="rounded">
                @elseif($image)
                    <img height="270" width="280" src="{{ $image->temporaryUrl() }}">
                @endif


            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI" class="btn btn-dark close-btn text-info"
                    data-bs-dismiss="modal">Cerrar</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">Guardar</button>
                @else
                    <button data-bs-dismiss="modal" type="button" wire:click.prevent="Delete()"
                        class="btn btn-danger close-modal">Eliminar</button>
                @endif

            </div>
        </div>
    </div>
</div>
