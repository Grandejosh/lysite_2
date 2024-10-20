<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('setting_subscriptions') }}">Modos de Suscripción</a></li>
            <li class="breadcrumb-item active">Nuevo</li>
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
                                <label class="form-label" for="price">Precio *</label>
                                <input wire:model="price" type="text" class="form-control" id="price"
                                    placeholder="price ..">
                                @error('price')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="dollar_price">Precio en Dolares*</label>
                                <input wire:model="dollar_price" type="text" class="form-control" id="dollar_price"
                                    placeholder="Precio en dolares ..">
                                @error('dollar_price')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="ai_oportunities">Oportunidades de usar IA*</label>
                                <input wire:model="ai_oportunities" type="number" class="form-control"
                                    id="ai_oportunities"
                                    placeholder="Veces que podrán usarse el parafraseo, recomendador, IA, etc..">
                                @error('ai_oportunities')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="until_subscription">Meses de subscripción(y meses para ver cursos)*</label>
                                <input wire:model="until_subscription" type="number" class="form-control"
                                    id="until_subscription" placeholder="Suma la cantidad de meses a la subscripción">
                                @error('until_subscription')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="allowed_thesis">Permisos para Tesis*</label>
                                <input wire:model="allowed_thesis" type="number" class="form-control"
                                    id="allowed_thesis" placeholder="Suma oportunidades para crear Tesis">
                                @error('allowed_thesis')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_one">Forma de pago *</label>
                                <input wire:model="detail_one" type="text" class="form-control" id="detail_one"
                                    placeholder="Forma de pago ..">
                                @error('detail_one')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_two">Detalle uno *</label>
                                <input wire:model="detail_two" type="text" class="form-control" id="detail_two"
                                    placeholder="Detalle uno ..">
                                @error('detail_two')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_three">Detalle dos *</label>
                                <input wire:model="detail_three" type="text" class="form-control" id="detail_three"
                                    placeholder="Detalle dos ..">
                                @error('detail_three')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_four">Detalle tres *</label>
                                <input wire:model="detail_four" type="text" class="form-control" id="detail_four"
                                    placeholder="Detalle tres ..">
                                @error('detail_four')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_five">Detalle cuatro </label>
                                <input wire:model="detail_five" type="text" class="form-control" id="detail_five"
                                    placeholder="Detalle cuatro ..">
                                @error('detail_five')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_six">Detalle Cinco </label>
                                <input wire:model="detail_six" type="text" class="form-control" id="detail_six"
                                    placeholder="Detalle Cinco ..">
                                @error('detail_six')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_seven">Detalle seis </label>
                                <input wire:model="detail_seven" type="text" class="form-control"
                                    id="detail_seven" placeholder="Detalle seis ..">
                                @error('detail_seven')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="detail_eight">Detalle siete </label>
                                <input wire:model="detail_eight" type="text" class="form-control"
                                    id="detail_eight" placeholder="Detalle seis ..">
                                @error('detail_eight')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('set-subscription-modes-create', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
