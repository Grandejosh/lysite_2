
<section style="width: 100%">
    {{-- <div class="row justify-content-between">
        <div class="col-4 align-middle">
            <p class="text-white mt-4">
                &copy; 2024 todos los derechos reservados
            </p>
        </div>
        <div class="col-2 align-middle">
            <p class="text-white mt-4">
                <a href="{{ route('terms_conditions') }}" target="_blank" class="text-white">Términos y condiciones</a>
            </p>
        </div>
        <div class="col-2 align-middle">
            <p class="text-white mt-4">
                <a href="{{ route('lyon_librodereclamos') }}" target="_blank" class="text-center">
                    <span class="text-white">libro de reclamaciones</span>
                    <img src="/img/libro-escribiendo.svg" style="width: 120px;height:120px" />
                </a>
            </p>
        </div>
    </div> --}}

    <footer class="bg-black text-white">
      <br>
        <div class="container p-4">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-2">
              <div class="mb-4 mx-auto">
                  <img class="img-leon"
                        src="{{ ENV('APP_URL') }}/theme-lyontech/images/leon.png" alt=""
                        loading="lazy" />
              </div>
            </div>
            <div class="col-md-2">
              <div>
                <div class="navbar-brand">
                  <b style="font-size: 40px;">
                      Lyonteach
                  </b>
                </div>
                <p style="font-size: 14px;">
                  TU INVESTIGACIÓN MAS FACIL, AHORA.
                </p>
                <ul class="list-unstyled d-flex flex-row">
                  <li>
                    <a target="_blank" class="text-white px-2" href="https://www.facebook.com/lyonteach0216">
                      <i class="fab fa-facebook-square"></i>
                    </a>
                  </li>
                  <li>
                    <a target="_blank" class="text-white px-2" href="https://www.instagram.com/lyonteach">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </li>
                  <li>
                      <a class="text-white ps-2" href="#!">
                        <i class="fab fa-youtube"></i>
                      </a>
                    </li>
                    <li>
                      <a target="_blank" class="text-white ps-2" href="https://www.tiktok.com/@lyonteach0216">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/></svg>
                      </a>
                    </li>
                </ul>
              </div>
            </div>
            <div class="col-md-4"></div>
          </div>
          <div class="row my-4">
            <div class="col-md-3 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-4 text-left" style="color: #ff9152;">
                HERRAMIENTAS
              </h5>

              <ul class="list-unstyled text-left">
                <li class="mb-2">
                  <a href="{{ route('help_gpt_default') }}" class="text-white"></i>Consultas IA</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('worksheet_default') }}" class="text-white"></i>Hoja de Trabajo</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('dashboard') }}" class="text-white"></i>Mis investigaciones</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('dashboard_courses_default') }}" class="text-white"></i>Cursos</a>
                </li>
                <li class="mb-2">
                  <a href="#!" class="text-white"></i>Chats</a>
                </li>
              </ul>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-4 text-left" style="color: #ff9152;">
                Nosotros
              </h5>

              <ul class="list-unstyled text-left">
                <li class="mb-2">
                  <a target="_blank" href="{{ route('privacy_policy') }}" class="text-white"></i>Políticas de privacidad</a>
                </li>
                <li class="mb-2">
                  <a target="_blank" href="{{ route('lyon_librodereclamos') }}" class="text-white"></i>Libro de reclamaciones</a>
                </li>
                <li class="mb-2">
                  <a target="_blank" href="{{ route('terms_conditions') }}" class="text-white"></i>Términos y condiciones</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('modo_page') }}" class="text-white"></i>Membresias</a>
                </li>
                <li class="mb-2">
                  <a href="#!" class="text-white"></i>Presentación</a>
                </li>
              </ul>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-4 text-left" style="color: #ff9152;">
                Contacto
              </h5>
              <ul class="list-unstyled text-left">
                <li class="mb-2">
                  <i class="fas fa-map-marker-alt pe-2"></i>&nbsp; Chimbote, 57 Street, Perú
                </li>
                <li class="mb-2">
                  <i class="fas fa-phone pe-2"></i>&nbsp; +51 922-477-831
                </li>
                <li class="mb-2">
                  <i class="fas fa-envelope pe-2 mb-0"></i>&nbsp; {{ env('MAIL_FROM_ADDRESS') }}
                </li>
                <li class="mb-2">
                  <a target="_blank" href="https://api.whatsapp.com/send?phone=51922477831&amp;text=Hola&nbsp;Lyonteach!&nbsp;me&nbsp;pueden&nbsp;ayudar con mi investigación?" class="wtsapp" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="text-white fab fa-whatsapp">&nbsp; Whatsapp</i>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-4 text-left" style="color: #ff9152;">
                  Acceso
              </h5>
              <ul class="list-unstyled text-left">
                <li class="mb-2">
                  <a href="{{ route('ly-login') }}" class="text-white"></i>Iniciar Sesión</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('register') }}" class="text-white"></i>Registrarse</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('register') }}" class="text-white"></i>Empezar gratis</a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('password.request') }}" class="text-white"></i>Olvido su contraseña</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
          RUC: 20612240541 - Lyonteach Educational Research  Technology S.A.C.
          <a class="text-white" href="{{ ENV("APP_URL") }}">©Lyonteach 2025</a>
        </div>
        <!-- Copyright -->
      </footer>

      <style>

        .img-leon{
              width: 50%;
            }

        @media (min-width: 600px) {
            .img-leon{
              width: 100%;
            }
        }
      </style>

</section>
