<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('setting_roles') }}">Roles</a></li>
            <li class="breadcrumb-item">Permisos</li>
            <li class="breadcrumb-item active">{{ $this->role_name }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            @php
                $module_name = '';
            @endphp
            @foreach($modules_permissions as  $module)
                @if($module->label != $module_name)
                    <div class="card mb-32pt">
                        <div class="card-body row">
                            <div class="col-lg-4">
                                <h4 class="card-title">{{ $module->label }}</h4>
                                <p class="text-70">Modulo</p>
                            </div>
                            <div class="col-lg-8 d-flex align-items-center">
                                <!-- Wrapper -->
                                <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                                    <!-- Table -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @foreach($modules_permissions as $key => $permission)
                                                @if($permission->label == $module->label)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                        <td class="name align-middle">
                                                            <div class="custom-control custom-checkbox">
                                                                @if($permission->state)
                                                                <input wire:change="xremove({{ $permission->id }})" checked id="customCheck0{{ $key }}" type="checkbox" class="custom-control-input">
                                                                <label for="customCheck0{{ $key }}" class="custom-control-label">{{ $permission->name }}</label>
                                                                @else
                                                                <input wire:change="xassign({{ $permission->id }})" id="customCheck0{{ $key }}" type="checkbox" class="custom-control-input">
                                                                <label for="customCheck0{{ $key }}" class="custom-control-label">{{ $permission->name }}</label>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $module_name = $module->label;
                    @endphp
                @endif
            @endforeach
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
        window.addEventListener('set-role-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });

        window.addEventListener('set-role-permission-add', event => {
            cuteAlert({
                type: 'success',
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })

    </script>
</div>