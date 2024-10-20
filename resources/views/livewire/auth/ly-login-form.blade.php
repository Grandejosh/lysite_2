<div class="container-section">
    <div class="pc-screen">
        <div class="row">
            <div class="col-md-9 box-plane-login">
                <div class="row box-plane-content-login">
                    @if (count($modos) > 0)
                        @foreach ($modos as $modo)
                            <div class="col-md-3">
                                <div class="box-plane-card-login">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="mb-0" style="text-align: center;">
                                                {{ $modo->name }}
                                            </h2>
                                            @if ($modo->price == 0)
                                                    <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 21px;">
                                                        <strong>-</strong>
                                                    </p>
                                                    <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 18px;">
                                                        <strong>-</strong>
                                                    </p>
                                            @else
                                                    <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 21px;">
                                                        <strong>S/ {{ $modo->price }}</strong>
                                                        <strong>ó</strong>
                                                    </p>
                                                    <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 18px;">
                                                        <strong>$USD {{ $modo->dollar_price }}</strong>
                                                    </p>
                                            @endif
                                            <p class="mt-0 mb-0 text-center" style="color: #ff9152; font-size: 18px;">
                                                <strong>/{{ $modo->detail_one }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul>
                                                <li>{{ $modo->detail_two }}</li>
                                                <li>{{ $modo->detail_three }}</li>
                                                <li>{{ $modo->detail_four }}</li>
                                                @if ($modo->detail_five && $modo->detail_five !== 'null')
                                                    <li>{{ $modo->detail_five }}</li>
                                                @endif

                                                @if ($modo->detail_six && $modo->detail_six !== 'null')
                                                    <li>{{ $modo->detail_six }}</li>
                                                @endif

                                                @if ($modo->detail_seven && $modo->detail_seven !== 'null')
                                                    <li>{{ $modo->detail_seven }}</li>
                                                @endif

                                                @if ($modo->detail_eight && $modo->detail_eight !== 'null')
                                                    <li>{{ $modo->detail_eight }}</li>
                                                @endif
                                            </ul>
                                            @if ($modo->price > 0)
                                                <a href="{{ route('unirme_page', $modo->id) }}"
                                                    class="form-control btn btn-orange submit">Unirse</a>
                                            @else
                                                <a href="{{ route('register') }}"
                                                    class="form-control btn btn-secondary submit">Registrado</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-3 box-plane-sesion">
                <div class="row box-plane-content-sesion">
                    <div class="col md-12">
                        <div class="box-plane-card-sesion">
                            <h1 class="mb-0">Iniciar Sesión</h1>
                            <p class="mt-0" style="font-size: 18px;">¿Usuario nuevo?
                                <a href="{{ route('register') }}" style="color: #0059ff;">Registrarme</a>
                            </p>
                            <br>
                            <form class="signin-form">
                                @csrf
                                <div class="form-login">
                                    <label for="email"><strong>Correo electrónico</strong></label>
                                    <input wire:model="email" id="email" type="email" name="email" required>
                                    @error('email')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-login">
                                    <label for="password"><strong>Contraseña</strong></label>
                                    <span onclick="showPassword()" style="right: 10px;"
                                        title="Mostrar/Ocultar Contraseña">
                                        <i class="fa fa-eye-slash" id="ojo_que_todo_lo_ve" aria-hidden="true"></i>
                                    </span>
                                    <input wire:model="password" wire:keydown.enter="login" id="password"
                                        name="password" type="password" required>
                                    @error('password')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror

                                </div>
                                @if (session()->has('message'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <div class="form-group-c btn-cent-c">
                                    <button wire:click="login" type="button"
                                        class="form-control btn btn-orange submit ">Iniciar
                                        Sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="movil-screen">
        <div class="row">
            <div class="col-md-4 box-plane-sesion">
                <div class="row box-plane-content-sesion">
                    <div class="col md-12">
                        <div class="box-plane-card-sesion">
                            <h1 class="mb-0">Iniciar Sesión</h1>
                            <p class="mt-0" style="font-size: 22px;">¿Usuario nuevo?
                                <a href="{{ route('register') }}" style="color: #0059ff;">Registrarme</a>
                            </p>
                            <br>
                            <form class="signin-form">
                                @csrf
                                <div class="form-login">
                                    <label for="email"><strong>Correo electrónico</strong></label>
                                    <input wire:model="email" id="email" type="email" name="email" required>
                                    @error('email')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-login">
                                    <label for="password"><strong>Contraseña</strong></label>
                                    <span onclick="showPassword()" title="Mostrar/Ocultar Contraseña">
                                        <i class="fa fa-eye-slash" id="ojo_que_todo_lo_ve" aria-hidden="true"></i>
                                    </span>
                                    <input wire:model="password" wire:keydown.enter="login" id="password"
                                        name="password" type="password" required>

                                    @error('password')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if (session()->has('message'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <div class="form-group-c btn-cent-c">
                                    <button wire:click="login" type="button"
                                        class="form-control btn btn-orange submit ">Iniciar
                                        Sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 box-plane-login">
                <div class="row box-plane-content-login">
                    @if (count($modos) > 0)
                        @foreach ($modos as $modo)
                            <div class="col-md-4">
                                <div class="box-plane-card-login">
                                    <h2 style="text-align: center;">{{ $modo->name }}</h2>
                                        @if ($modo->price == 0)
                                                        <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 21px;">
                                                            <strong>-</strong>
                                                            <strong></strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 18px;">
                                                            <strong>-</strong>
                                                        </p>
                                        @else
                                                        <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 21px;">
                                                            <strong>S/ {{ $modo->price }}</strong>
                                                            <strong>ó</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 18px;">
                                                            <strong>$USD {{ $modo->dollar_price }}</strong>
                                                        </p>
                                        @endif
                                    <ul>
                                        <li>{{ $modo->detail_two }}</li>
                                        <li>{{ $modo->detail_three }}</li>
                                        <li>{{ $modo->detail_four }}</li>
                                        @if ($modo->detail_five && $modo->detail_five !== 'null')
                                            <li>{{ $modo->detail_five }}</li>
                                        @endif

                                        @if ($modo->detail_six && $modo->detail_six !== 'null')
                                            <li>{{ $modo->detail_six }}</li>
                                        @endif

                                        @if ($modo->detail_seven && $modo->detail_seven !== 'null')
                                            <li>{{ $modo->detail_seven }}</li>
                                        @endif

                                        @if ($modo->detail_eight && $modo->detail_eight !== 'null')
                                            <li>{{ $modo->detail_eight }}</li>
                                        @endif
                                    </ul>
                                    @if ($modo->price > 0)
                                        <a href="{{ route('unirme_page', $modo->id) }}"
                                            class="form-control btn btn-orange submit">Unirse</a>
                                    @else
                                        <a href="{{ route('register') }}"
                                            class="form-control btn btn-secondary submit">Registrado</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <script>
            function showPassword() {
                pass = document.getElementById('password');
                if (pass.type == 'password') {
                    pass.type = 'text';
                    document.getElementById('ojo_que_todo_lo_ve').classList.add('fa-eye');
                    document.getElementById('ojo_que_todo_lo_ve').classList.remove('fa-eye-slash');
                } else {
                    pass.type = 'password';
                    document.getElementById('ojo_que_todo_lo_ve').classList.add('fa-eye-slash');
                    document.getElementById('ojo_que_todo_lo_ve').classList.remove('fa-eye');
                }
            }
        </script>
    </div>
</div>
