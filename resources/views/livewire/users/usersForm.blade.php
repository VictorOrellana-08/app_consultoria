<div wire:ignore.self id="themodal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><b>{{ $componentName }}</b> |
                    {{ $selected_id > 0 ? 'Edit' : 'Create' }}</h5>
                <h6 class="text-center text-warning" wire:loading>Please wait...</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-8">


                        <div class="form-group">
                            <label class="text-white">Nombre</label>

                            <input type="text" wire:model.lazy='name' class="form-control"
                                placeholder="Nombre">
                        </div>

                        @error('name')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="col-sm-12 col-md-8">


                        <div class="form-group">
                            <label class="text-white">Usuario</label>

                            <input type="text" wire:model.lazy='username' class="form-control"
                                placeholder="Usuario">
                        </div>

                        @error('username')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror

                    </div>



                    <div class="col-sm-12 col-md-4">

                        <div class="form-group">
                            <label class="text-white" for="">Teléfono</label>

                            <input type="text" wire:model.lazy='phone' class="form-control"
                                placeholder="Teléfono" maxlenght="10">
                            @error('phone')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="col-sm-12 col-md-6 mt-3">


                        <div class="form-group">
                            <label class="text-white">Email</label>
                            <input type="text" wire:model.lazy='email' class="form-control"
                                placeholder="Email">
                            @error('email')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>


                    <div class="col-sm-12 col-md-6 mt-3">

                        <div class="form-group">
                            <label class="text-white" class="text-white" for="">Contraseña</label>

                            <input type="text" wire:model.lazy='password' class="form-control" placeholder="Contraseña">

                            @error('password')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-6 mt-3">
                        <div class="form-group">
                            <label class="text-white">Asignar Rol</label>
                            <select wire:model.lazy="profile" class="form-control">
                                <option value="Elegir" selected>Choose</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('profile')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 mt-3">
                        <div class="form-group">
                            <label class="text-white" for="">Estatus</label>
                            <select class="form-select" wire:model="status">
                                <option value="Elegir" selected disabled>Elige estado...</option>
                                <option value="ACTIVE">ACTIVO</option>
                                <option value="LOCKED">BLOQUEADO</option>

                            </select>
                            @error('status')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-12 mt-3">


                        <div class="col-sm-12 mt-1">
                            <div class="mb-3">
                                <label class="text-white" for="formFile" class="form-label">Imagen</label>
                                <input class="form-control" type="file" wire:model="tempImage" id="formFile">
                            </div>


                            @if ($selected_id > 0 && !$tempImage)
                                <img src="{{ asset('storage/' . $image) }}" alt="" height="70"
                                    width="80" class="rounded">
                            @elseif($tempImage)
                                <img height="270" width="280" src="{{ $tempImage->temporaryUrl() }}">
                            @endif




                            @error('image')
                                <span class="error">{{ $message }}</span>
                            @enderror


                        </div>






                        @error('image')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror

                    </div>
                </div>


                @include('common.modalzFooter')
