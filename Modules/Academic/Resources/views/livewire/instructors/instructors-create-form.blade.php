<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_instructors_list') }}">{{ __('academic::labels.instructors') }}</a></li>
            <li class="breadcrumb-item active">{{ __('academic::labels.new') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro {{ __('academic::labels.instructors') }}</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Tipo Documento  *</label>
                                        <select class="form-control" wire:model="document_type_id">
                                            <option value="">Seleccionar</option>
                                            @foreach($document_types as $document_type)
                                            <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                                            @endforeach
                                        </select>
                                        @error('document_type_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="number">Número documento *</label>
                                        <div class="input-group">
                                            <input wire:model="number" type="text" class="form-control">
                                            <div class="input-group-append">
                                              <button wire:click="searchDni" wire:target="searchDni" wire:loading.attr="disabled" class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button>
                                            </div>
                                          </div>
                                        @error('number') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="divForminstructor" style="display: none" wire:ignore.self>
                                <div class="row" >
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="last_name_father">Apellido Paterno *</label>
                                            <input wire:model="last_name_father" type="text" class="form-control" id="name">
                                            @error('last_name_father') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="last_name_mother">Apellido Materno *</label>
                                            <input wire:model="last_name_mother" type="text" class="form-control" id="name">
                                            @error('last_name_mother') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
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
                                            <label class="form-label" for="birth_date">{{ __('labels.Date of Birth') }}</label>
                                            <input wire:model="birth_date" onchange="this.dispatchEvent(new InputEvent('input'))" id="birth_date" type="text" class="form-control">
                                            @error('birth_date') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                        </div> 
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.Region') }}</label>
                                            <select wire:change="getProvinces" wire:model="department_id" class="form-control">
                                                <option value="">Seleccionar</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->description }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.Province') }}</label>
                                            <select wire:change="getDistricts" wire:model="province_id" class="form-control">
                                                <option value="">{{ __('labels.Select') }}</option>
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->description }}</option>
                                                @endforeach
                                            </select>
                                            @error('province_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
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
                                            @error('district_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.Address') }}</label>
                                            <input wire:model="address" type="text" class="form-control">
                                            @error('address') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
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
                                            <input wire:model="mobile_phone" type="text" class="form-control" id="mobile_phone">
                                            @error('mobile_phone') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
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
                                                <input wire:model="status" class="custom-control-input" type="checkbox" value="" id="invalidCheck01" >
                                                <label class="custom-control-label" for="invalidCheck01">
                                                    Estado
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h2>Datos de Instructor</h2>
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
                                                  <button wire:click="addCourse" wire:target="addCourse" wire:loading.attr="disabled" class="btn btn-primary" type="button" >Agregar</button>
                                                </div>
                                              </div>
                                            @error('course_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre Del Curso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($instructor_courses)
                                                    @foreach($instructor_courses as $key => $instructor_course)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $instructor_course['name'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td class="text-center" colspan="2">No está registrado en ningún curso</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn btn-primary">Guardar</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-instructor-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
        window.addEventListener('aca-person-notnull', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
            $('#divForminstructor').css('display', 'block');
        });
        window.addEventListener('aca-person-null', event => {
            cuteAlert({
                type: "question",
                title: event.detail.tit,
                message: event.detail.msg,
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    $('#divForminstructor').css('display', 'block');
                } 
            });
        });
        document.addEventListener('livewire:load', function () {
            $("#birth_date").flatpickr();
        });
    </script>
</div>
