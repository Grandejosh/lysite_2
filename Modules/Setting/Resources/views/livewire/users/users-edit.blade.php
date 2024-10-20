<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('setting_users') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">
                            <div class="form-group">
                                <label class="form-label" for="name">Nombre *</label>
                                <input wire:model="name" type="text" class="form-control" id="name"
                                    placeholder="Nombre ..">
                                @error('name')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Email *</label>
                                <input wire:model="email" type="text" class="form-control" id="email"
                                    placeholder="Email ..">
                                @error('email')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Contraseña *</label>
                                <input wire:model="password" type="text" class="form-control" id="password"
                                    placeholder="Contraseña ..">
                                @error('password')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Rol *</label>
                                <select wire:model="role_id" class="form-control" id="role_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subscribe">Permisos de trabajo</label>
                                <div class="flex mb-2">
                                    <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                        <input wire:model="gpt" type="checkbox" id="gpt"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="gpt">gpt</label>
                                    </div>
                                    <label class="form-label mb-0" for="gpt">Asistente GPT</label>
                                </div>
                                <div class="flex mb-2">
                                    <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                        <input wire:model="cur" type="checkbox" id="cursos"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="cursos">cur</label>
                                    </div>
                                    <label class="form-label mb-0" for="cursos">Cursos</label>
                                </div>
                                <div class="flex mb-2">
                                    <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                        <input wire:model="tes" type="checkbox" id="tesis"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="tesis">tes</label>
                                    </div>
                                    <label class="form-label mb-0" for="tesis">Desarrollo de Tesis</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('set-users-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
