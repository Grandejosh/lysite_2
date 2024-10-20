<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_students') }}">{{ __('academic::labels.students')
                    }}</a></li>
            <li class="breadcrumb-item">{{ $this->person->full_name }}</li>
            <li class="breadcrumb-item active">{{ __('academic::labels.edit') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro {{ __('academic::labels.students') }}</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Tipo Documento *</label>
                                        <select class="form-control" wire:model="document_type_id">
                                            <option value="">Seleccionar</option>
                                            @foreach($document_types as $document_type)
                                            <option value="{{ $document_type->id }}">{{ $document_type->description }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('document_type_id') <span class="invalid-feedback-2">{{ $message
                                            }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="number">Número documento *</label>
                                        <input wire:model="number" type="text" class="form-control">
                                        @error('number') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="last_name_father">Apellido Paterno *</label>
                                        <input wire:model="last_name_father" type="text" class="form-control" id="name">
                                        @error('last_name_father') <span class="invalid-feedback-2">{{ $message
                                            }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="last_name_mother">Apellido Materno *</label>
                                        <input wire:model="last_name_mother" type="text" class="form-control" id="name">
                                        @error('last_name_mother') <span class="invalid-feedback-2">{{ $message
                                            }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="names">Nombre *</label>
                                        <input wire:model="names" type="text" class="form-control" id="name">
                                        @error('names') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="birth_date">{{ __('labels.Date of Birth')
                                            }}</label>
                                        <input wire:model="birth_date"
                                            onchange="this.dispatchEvent(new InputEvent('input'))" id="birth_date"
                                            type="text" class="form-control">
                                        @error('birth_date') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('labels.Region') }}</label>
                                        <select wire:change="getProvinces" wire:model="department_id"
                                            class="form-control">
                                            <option value="">Seleccionar</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->description }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('labels.Province') }}</label>
                                        <select wire:change="getDistricts" wire:model="province_id"
                                            class="form-control">
                                            <option value="">{{ __('labels.Select') }}</option>
                                            @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->description }}</option>
                                            @endforeach
                                        </select>
                                        @error('province_id') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('labels.District') }}</label>
                                        <select wire:model="district_id" class="form-control">
                                            <option value="">{{ __('labels.Select') }}</option>
                                            @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->description }}</option>
                                            @endforeach
                                        </select>
                                        @error('district_id') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('labels.Address') }}</label>
                                        <input wire:model="address" type="text" class="form-control">
                                        @error('address') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email *</label>
                                        <input wire:model="email" type="text" class="form-control" id="name">
                                        @error('email') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="mobile_phone">Telefono *</label>
                                        <input wire:model="mobile_phone" type="text" class="form-control"
                                            id="mobile_phone">
                                        @error('mobile_phone') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('labels.Gender') }}</label>
                                        <select wire:model="sex" class="form-control">
                                            <option value="">{{ __('labels.Select') }}</option>
                                            <option value="1">{{ __('labels.Male') }}</option>
                                            <option value="0">{{ __('labels.Female') }}</option>
                                        </select>
                                        @error('sex') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input wire:model="status" class="custom-control-input" type="checkbox"
                                                value="" id="invalidCheck01">
                                            <label class="custom-control-label" for="invalidCheck01">
                                                Estado
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2>Datos de Estudiante</h2>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('academic::labels.courses') }}</label>
                                        <div class="input-group">
                                            <select wire:model="course_id" class="form-control">
                                                <option value="">{{ __('labels.Select') }}</option>
                                                @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button wire:click="addCourse" wire:target="addCourse"
                                                    wire:loading.attr="disabled" class="btn btn-primary"
                                                    type="button">{{ __('labels.Add') }}</button>
                                            </div>
                                        </div>
                                        @error('course_id') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Acciones</th>
                                                <th>Nombre Del Curso</th>
                                                <th class="text-center">{{ __('labels.Registered until') }}</th>
                                                <th class="text-center">{{ __('labels.Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($student_courses)
                                            @foreach($student_courses as $key => $student_course)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">
                                                    <button onclick="deletes({{ $key }},{{ $student_course['id'] }})"
                                                        type="button" class="btn btn-danger btn-sm" title="Eliminar"><i
                                                            class="fa fa-trash-alt"></i></button>
                                                </td>
                                                <td>{{ $student_course['name'] }}</td>
                                                <td>
                                                    <input type="date"  name="registered_until" id="registered_until" onchange="uploadDates({{ $key }}, this.value)"
                                                        value="{{ $student_course['registered_until'] }}">
                                                </td>
                                                @if ($student_course['status'] == 1)
                                                <td class="text-center">
                                                    <span class="badge badge-success">{{ __('labels.Active') }}</span>
                                                </td>

                                                @else
                                                <td class="text-center">
                                                    <span class="badge badge-danger">{{ __('labels.Inactive') }}</span>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="3">No está registrado en ningún curso
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                                class="btn btn-primary">Guardar Cambios</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function uploadDates(key, date){
            @this.updateDate(key, date);
        }
        function deletes(index,id){
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.removeCourse(index,id)
                }
            });
        }
        window.addEventListener('aca-student-delete-course', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
        window.addEventListener('aca-student-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
        document.addEventListener('livewire:load', function () {
            $("#birth_date").flatpickr();
        });
    </script>
</div>
