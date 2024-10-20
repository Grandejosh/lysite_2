<div>
    <div class="card">
        <div class="card-body mt-3">
            <h5 class="text-center" style="font-weight: bold;"><strong
                    style="font-size: 2.1rem; font-weight: bold;letter-spacing: 0.0em; line-height: 1;">
                    Verificiación de cuenta</strong></h5>
            <div class="text-cuenta">
                <p>Para brindar mayor protección a tu cuenta Lyonteach </p>
                <p>quiere verificar tu identidad en simples pasos.</p>
            </div>
            <div class="text-cuenta-b  ml-1 mt-2">
                <p>Se acaba de enviar un código de 6 dígitos a la bandeja del correo</p>
                <p> electrónico registrado en nuestra plataforma.</p>

            </div>
            <form wire:submit.prevent="validateCode" class="signin-form mt-2">
                <div class="form-login mt-3">
                    <input wire:model="unique_code" type="text" required placeholder="Escribe el codigo">
                </div>
                <div class="form-a">
                    <a wire:click="resendCode" href="#">Reenviar el código</a>
                </div>
                <div class="form-group mt-4 btn-cent mb-4">
                    <button type="submit" class="form-control btn btn-primary submit ">
                        <strong>Verificar
                            cuenta
                        </strong>
                    </button>
                </div>
            </form>
        </div>

    </div>
    <div class="modal fade" id="ventanaModalMessage" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="tituloVentana" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="text-center">{{ $title }}</h1>
                </div>
                <div class="modal-body">
                    <p>{{ $message }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button wire:click="resendCode" type="button" class="btn btn-secondary btn-lg"
                        data-dismiss="modal">
                        <strong>Reenviar el código</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('validate-code-response', event => {
            $('#ventanaModalMessage').modal('show');
        })
    </script>
</div>
