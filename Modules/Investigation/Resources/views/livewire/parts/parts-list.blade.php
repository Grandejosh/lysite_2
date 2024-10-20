<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('investigation::labels.thesis_parts') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">{{ __('investigation::labels.parts') }}</p>
                        @can('investigacion_partes_nuevo')
                        <button wire:click="$emit('openModalPartCreate',{{ $format_id }})" type="button" class="btn btn-primary">Nuevo</button>
                        @endcan
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <ul class="list-point-none">
                            @if(count($parts) > 0)
                                @foreach($parts as $part)
                                    <li>
                                        <div class="btn-group mr-3">
                                            <label style="opacity:0.4; color:blue" data-toggle="tooltip" data-placement="top" title="Esto no se mostrará en las tesis">{{ $part['index_order'].">>"}} </label>
                                            <button wire:click="$emit('openModalPartCreate',{{ $format_id }},{{ $part['id'] }})" type="button" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <button wire:click="$emit('openModalPartEditForm',{{ $part['id'] }})" type="button" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
                                            <button onclick="deletes({{ $part['id'] }})" type="button" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        {{ $part['number_order'].' '.$part['description'] }}
                                        {!! $part['items']  !!}
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletes(id){
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.destroy(id)
                }
            });
        }
        window.addEventListener('inve-part-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
