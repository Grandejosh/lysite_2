
<div class="container page__container">
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-lg-9">
                <div class="page-section">
                    <h4>{{ __('labels.Basic information') }}</h4>
                    <div class="list-group list-group-form">
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Document type') }}</label>
                                <div class="col-sm-4">
                                    <select wire:model="identity_document_type_id" class="form-control">
                                        <option value="">{{ __('labels.Select') }}</option>
                                        @foreach ($identity_document_types as $identity_document_type)
                                            <option value="{{ $identity_document_type->id }}">
                                                {{ $identity_document_type->description }}</option>
                                        @endforeach
                                    </select>
                                    @error('identity_document_type_id')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Number') }}</label>
                                <div class="col-sm-4">
                                    <input wire:model="number" type="text" class="form-control">
                                    @error('number')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Name') }}</label>
                                <div class="col-sm-9">
                                    <input wire:model="names" type="text" class="form-control">
                                    @error('names')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Middle Name') }}</label>
                                <div class="col-sm-9">
                                    <input wire:model="last_name_father" type="text" class="form-control">
                                    @error('last_name_father')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Last Name') }}</label>
                                <div class="col-sm-9">
                                    <input wire:model="last_name_mother" type="text" class="form-control">
                                    @error('last_name_mother')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.country') }}</label>
                                <div class="col-sm-4">
                                    <div wire:ignore>
                                        <select wire:change="getProvinces" wire:model="country_id" class="form-control" id="countries">
                                            <option value="">Seleccionar</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('country_id')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.University') }}</label>
                                <div class="col-sm-9">
                                    <select wire:model="university_id" class="form-control" id="university_id">
                                        <option value="">Seleccionar</option>
                                        @foreach ($universities as $university)
                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('university_id')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($ubigeo_active)
                            <div class="list-group-item">
                                <div class="form-group row mb-0">
                                    <label class="col-form-label col-sm-3">{{ __('labels.Region') }}</label>
                                    <div class="col-sm-4">
                                        <select wire:change="getProvinces" wire:model="department_id" id="department_id"
                                            class="form-control">
                                            <option value="">Seleccionar</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="form-group row mb-0">
                                    <label class="col-form-label col-sm-3">{{ __('labels.Province') }}</label>
                                    <div class="col-sm-4">
                                        <select wire:change="getDistricts" wire:model="province_id" id="province_id"
                                            class="form-control">
                                            <option value="">{{ __('labels.Select') }}</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
                                            <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="form-group row mb-0">
                                    <label class="col-form-label col-sm-3">{{ __('labels.District') }}</label>
                                    <div class="col-sm-4">
                                        <select wire:model="district_id" class="form-control" id="district_id">
                                            <option value="">{{ __('labels.Select') }}</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('district_id')
                                            <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Address') }}</label>
                                <div class="col-sm-9">
                                    <input wire:model="address" type="text" class="form-control">
                                    @error('address')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Mobile Number') }}</label>
                                <div class="col-sm-4">
                                    <input wire:model="mobile_phone" type="text" class="form-control">
                                    @error('mobile_phone')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3"
                                    for="birth_date">{{ __('labels.Date of Birth') }}</label>
                                <div class="col-sm-4">
                                    <input wire:model="birth_date"
                                        onchange="this.dispatchEvent(new InputEvent('input'))" id="birth_date"
                                        type="text" class="form-control">
                                    @error('birth_date')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Gender') }}</label>
                                <div class="col-sm-4">
                                    <select wire:model="sex" class="form-control">
                                        <option value="">{{ __('labels.Select') }}</option>
                                        <option value="1">{{ __('labels.Male') }}</option>
                                        <option value="0">{{ __('labels.Female') }}</option>
                                    </select>
                                    @error('sex')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Email') }}</label>
                                <div class="col-sm-9">
                                    <input wire:model="email" type="email" class="form-control" disabled>
                                    @error('last_name_mother')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 page-nav">
                <div class="page-section pt-lg-112pt">
                    @livewire('user.nav')
                    <div class="page-nav__content">
                        <button type="submit" wire:target="save" wire:loading.attr="disabled"
                            class="btn btn-orange" style="padding: 5px 20px;">{{ __('labels.Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        var noloopu = true;
        var noloopd = true;
        var noloopp = true;
        var noloopd = true;
        window.addEventListener('set-person-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
        document.addEventListener('livewire:load', function() {
            $("#birth_date").flatpickr();
            $('#university_id').select2();
            $('#countries').select2();
            $('#department_id').select2();
            $('#province_id').select2();  
            $('#district_id').select2();  

            $('#countries').on('select2:select', function(e) {
                var data = e.params.data;
                console.log(data.id);
                @this.country_id = data.id; 
                @this.getUniversities();
                @this.getDeparments();
                @this.getProvinces();
                @this.getDistricts(); 
                @this.refreshSelect2s();   
                      
            });
            
             $('#university_id').on('select2:select', function(e) {
                 var data = e.params.data;              
                 @this.university_id = data.id; //aquí paso el id de la universidad
                 @this.refreshSelect2s();
             });
             $('#department_id').on('select2:select', function(e) {
                var data = e.params.data;              
                @this.department_id = data.id; //aquí paso el id
                console.log(data.id);
                @this.getProvinces();
             });
             $('#province_id').on('select2:select', function(e) {
                var data = e.params.data;              
                @this.province_id = data.id; //aquí paso el id    
                @this.getDistricts();     
             });
             $('#district_id').on('select2:select', function(e) {
                var data = e.params.data;              
                @this.district_id = data.id; //aquí paso el id                
                @this.refreshSelect2s();
             });

        });

        window.addEventListener('refreshSelect2s', event => {
                $('#university_id').select2(); 
                $('#department_id').select2(); 
                $('#province_id').select2();  
                $('#district_id').select2();  
                // $('#countries').on('select2:select', function(e) {                      
                //  });
                    //activando las escuchas de nuevo

                        $('#university_id').on('select2:select', function(e) {
                            if(noloopu){
                                var data = e.params.data;              
                                @this.university_id = data.id; //aquí paso el id de la universidad
                                @this.refreshSelect2s();
                                console.log("MASD1");
                            noloopu = false;
                            }else{
                                noloopu=true;
                            }
                        });
                        $('#department_id').on('select2:select', function(e) {
                            if(noloopd){
                            var data = e.params.data;              
                            @this.department_id = data.id; //aquí paso el id
                            @this.province_id = "";
                            @this.district_id = "";                            
                            @this.getProvinces();                        
                            console.log("MASD2");
                            noloop = false;
                            }else{
                                noloopd=true;
                            }
                        });
                        $('#province_id').on('select2:select', function(e) {
                            if(noloopp){
                                var data = e.params.data;              
                                @this.province_id = data.id; //aquí paso el id    
                                @this.getDistricts();   
                                console.log("MASD3"); 
                            noloopp = false;
                            }else{
                                noloopp=true;
                            }
 
                        });
                        $('#district_id').on('select2:select', function(e) {

                            if(noloopd){
                                var data = e.params.data;              
                                @this.district_id = data.id; //aquí paso el id                
                                @this.refreshSelect2s();
                                console.log("MASD4");
                            noloopd = false;
                            }else{
                                noloopd=true;
                            }
                        });
            });

    </script>
</div>
