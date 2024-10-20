<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('setting_modules') }}">Modules</a></li>
            <li class="breadcrumb-item">Permisos</li>
            <li class="breadcrumb-item active">{{ $this->module_name }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card mb-32pt">
                <div class="card-body row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <input wire:model.defer="name" type="text" class="form-control" placeholder="{{ $module_name_new }}" aria-label="Nombre del permiso" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button wire:click="savePermission" class="btn btn-primary" type="button" id="button-addon2">Agregar</button>
                                </div>
                            </div>
                            @error('permission_name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                        </div>
                        <p class="text-70">Crear permiso</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->
                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text" class="form-control search" placeholder="Search">
                                <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        @can('configuraciones_modulos_eliminar')
                                        <th class="text-center">Accion</th>
                                        @endcan
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($permissions as $key => $permission)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        @can('configuraciones_modulos_permiso_eliminar')
                                        <td class="text-center align-middle">
                                            <button onclick="deletes({{ $permission->id }})" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                                        </td>
                                        @endcan
                                        <td class="name align-middle">
                                            <div class="custom-control custom-checkbox">
                                                <input wire:change="changeState({{ $permission->id }})" {{ $permission->status ? 'checked' : '' }} id="customCheck0{{ $key }}" type="checkbox" class="custom-control-input">
                                                <label for="customCheck0{{ $key }}" class="custom-control-label">{{ $permission->name }}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $permissions->links() }}
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletes(id){
            cuteAlert({
                type: "question",
                title: "Confirm Title",
                message: "Confirm Message",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.destroy(id)
                } 
            });
        }
        window.addEventListener('set-module-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });

        window.addEventListener('set-module-permission-add', event => {
            cuteAlert({
                type: 'success',
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })

    </script>
</div>