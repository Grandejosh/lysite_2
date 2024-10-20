<div class="card {{ $info ? 'position-relative w-100 h-100' : '' }}">
    @if ($info)
        <h5>Crear cuenta</h5>
        <p>¿Ya tienes una cuenta? <a href="{{ route('ly-login') }}">Iniciar sesión </a></p>
        <form wire:submit.prevent="saveInfo" class="signin-form">
            <div class="form-row mt-2">
                <div class="form-login">
                    <label>ID:</label>
                    <input wire:model="number" type="text" wire:input="consultaDni" required placeholder="ID/DNI">
                    @error('number')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-login">
                    <label for="names">&nbsp;Nombres:</label>
                    <input wire:model="names" id="names" type="text" {{ $inputsDisabled ? 'disabled' : '' }} required>
                    @error('number')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="form-login">
                    <label for="last_name_father">&nbsp;Apellido Paterno:</label>
                    <input wire:model="last_name_father" id="last_name_father" type="text" {{ $inputsDisabled ? 'disabled' : '' }} required>
                    @error('last_name_father')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-login">
                    <label for="last_name_mother">&nbsp; Apellido Materno:</label>
                    <input wire:model="last_name_mother" type="text" id="last_name_mother" {{ $inputsDisabled ? 'disabled' : '' }} required>
                    @error('last_name_mother')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="form-login">
                    <label for="birth_date">&nbsp;Fecha de nacimiento:</label>
                    <input wire:model="birth_date" id="birth_date" type="date" required>
                    @error('birth_date')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="form-row  mt-2">
                <div class="form-select ">
                    <label for="department_id">&nbsp;Departamento:</label>
                    <select wire:model="department_id" wire:change="getProvences" id="department_id">
                        @if (count($departments) > 0)
                            <option value="">Seleccionar</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->description }}</option>
                            @endforeach
                        @else
                            <option value="">Sin Rregistros</option>
                        @endif
                    </select>
                    @error('department_id')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-select ">
                    <label>&nbsp;Provincia:</label>
                    <select wire:model="province_id" wire:change="getDistricts" name="provincia" id="">
                        @if (count($provinces) > 0)
                            <option value="">Seleccionar</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->description }}</option>
                            @endforeach
                        @else
                            <option value="">Sin Registros</option>
                        @endif
                    </select>
                    @error('province_id')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-select ">
                    <label for="district_id">&nbsp;Ciudad:</label>
                    <select wire:model="district_id" name="ciudad" id="district_id">
                        @if (count($districts) > 0)
                            <option value="">Seleccionar</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->description }}</option>
                            @endforeach
                        @else
                            <option value="">Sin Registros</option>
                        @endif
                    </select>
                    @error('district_id')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row  mt-2">
                <div class="form-select  ">
                    <label for="university_id">&nbsp;Universidad:</label>
                    <select wire:model="university_id" name="universidad" id="university_id">
                        @if (count($universities) > 0)
                            <option value="">Seleccionar</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                            @endforeach
                        @else
                            <option value="">Sin Registros</option>
                        @endif
                    </select>
                    @error('universidad')
                        <span class="invalid-feedback-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group  btn-cent">
                <button type="submit" class="form-control btn btn-primary submit ">Crear cuenta</button>
            </div>
        </form>
    @else
        <h5>Registrarme</h5>
        <p>¿Ya estás registrado? <a href="{{ route('ly-login') }}">Iniciar sesión </a></p>
        <form wire:submit.prevent="save" class="signin-form">
            <div class="form-login">
                <label for="email"><strong>Correo electrónico</strong></label>
                <input wire:model="email" id="email" type="email" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-login">
                <label for="password"><strong>Contraseña</strong></label>
                <input wire:model="password" id="password" type="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
                <span style="right: 10px;" toggle="#password"
                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <div class="form-select ">
                <label><strong>&nbsp;País:</strong></label>
                <select wire:model="country_id" name="pais" id="" style="padding-top: 5px;">
                    @if (count($countries) > 0)
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->description }}</option>
                        @endforeach
                    @endif
                </select>
                @error('country_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group btn-cent">
                <button type="submit" class="form-control btn btn-primary submit ">Registrarme</button>
            </div>
        </form>
    @endif
</div>
