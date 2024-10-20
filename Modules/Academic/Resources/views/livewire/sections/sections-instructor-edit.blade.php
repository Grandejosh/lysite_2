<div style="animation-fill-mode: unset !important;">
    <div class="container page__container page-section">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-heading d-flex align-items-center">
                    <h4 class="flex mb-0">{{ __('academic::labels.sections') }}</h4>
                </div>
                @if(count($sections) > 0)
                    @php
                        $total = count($sections);
                        $c = 1;
                    @endphp
                    @foreach($sections as $key => $section)
                        <div class="card stack" style="display: {{ $section_edit[$key] == false ? 'block' : 'none' }}">
                            <div class="card-header">
                                <h4 class="card-title mb-0">{{ $section['title'] }}</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{ $section['description'] }}</li>
                                <li class="list-group-item">
                                    @if($section['status'])
                                        <span class="badge badge-success">{{ __('academic::labels.active') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('academic::labels.inactive') }}</span>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <button onclick="deletesSecion({{ $c }},{{ $section['id'] }})" type="button" class="btn btn-danger btn-sm">Eliminar</button>
                                    <button wire:click="activeEdit({{ $key }})" type="button" class="btn btn-accent btn-sm">{{ __('academic::labels.edit') }}</button>
                                    <button wire:click="$emit('instructorOpenModal', {{ $section['id'] }});" type="button" class="btn btn-primary btn-sm">{{ __('academic::labels.add_content') }}</button>

                                    @if($c > 1)
                                        <button wire:click="changeordernumber('1','{{ $section['id'] }}','{{ $c }}','{{ $key }}')" type="button" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-arrow-up"></i>
                                        </button>
                                    @endif
                                    @if($total > $c)
                                        <button wire:click="changeordernumber('0','{{ $section['id'] }}','{{ $c }}','{{ $key }}')" type="button" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-arrow-down"></i>
                                        </button>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div id="div{{ $key }}" class="card stack" style="display: {{ $section_edit[$key] == false ? 'none' : 'block' }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label" for="title{{ $key }}">{{ __('academic::labels.title') }}</label>
                                    <input wire:model="sections.{{ $key }}.title" name="sections[{{ $key }}].title" id="title{{ $key }}" type="text" class="form-control" autocomplete="off">
                                    @error('sections.'.$key.'.title') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="title{{ $key }}">{{ __('academic::labels.description') }}</label>
                                    <textarea wire:model="sections.{{ $key }}.description" name="sections[{{ $key }}].description" id="title{{ $key }}" class="form-control"></textarea>
                                    @error('sections.'.$key.'.description') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox" wire:ignore>
                                        <input wire:model="sections.{{ $key }}.status" value="sections.{{ $key }}.id" class="custom-control-input" type="checkbox" id="check0{{ $key }}">
                                        <label class="custom-control-label" for="check0{{ $key }}">
                                            {{ __('academic::labels.active') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button wire:click="inactiveEdit({{ $key }})" class="btn btn-default" >Cancelar</button>
                                <button wire:click="saveChangesSection({{ $key }})" class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                        @php
                            $c++;
                        @endphp
                    @endforeach
                @endif
                <button wire:click="addSection" type="button" class="btn btn-outline-secondary mb-24pt mb-sm-0">{{ __('academic::labels.add_section') }}</button>
            </div>
            <div class="col-md-4">

                <div class="mb-heading d-flex align-items-center">
                    <h4 class="flex mb-0">{{ __('academic::labels.main_video') }}</h4>
                    <a wire:click="$emit('instructorOpenModalMainTrailer',{{ $course->id }});" href="#" class="text-underline">{{ __('academic::labels.edit') }}</a>
                </div>

                <div class="card">

                    <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                        <div class="player embed-responsive-item">
                            <div class="player__content">
                                <div class="player__image" style="--player-image: url(assets/images/illustration/player.svg)">
                                </div>
                                <a href="" class="player__play">
                                    <span class="material-icons">play_arrow</span>
                                </a>
                            </div>
                            <div class="player__embed d-none">
                                <!-- Aqui abajo va el Video -->
                                @if ($video==0)
                                <iframe class="embed-responsive-item"
                                    src="https://player.vimeo.com/video/{{ $course->main_video }}?title=0&amp;byline=0&amp;portrait=0"
                                    allowfullscreen=""></iframe>
                                @endif
                                @if ($video==1)
                                <iframe class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/{{ $course->main_video }}?title=0&amp;byline=0&amp;portrait=0"
                                    allowfullscreen=""></iframe>
                                @endif
                                <!-- Aqui arriba va el Video -->
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <div class="mb-heading d-flex align-items-center">
                    <h4 class="flex mb-0">Course Options</h4>
                    <a href="#" class="text-underline">Add</a>
                </div> --}}

                {{-- <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" class="form-control custom-select">
                                <option value="vuejs">VueJs</option>
                                <option value="vuejs">Angular</option>
                                <option value="vuejs">React</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group form-inline">
                                        <span class="input-group-prepend"><span class="input-group-text">$</span></span>
                                        <input type="text" class="form-control" value="24">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <input type="text" name="tags" class="form-control" placeholder="enter, badges, here">
                            <small class="form-text text-muted">Separate tags with space or comma.</small>
                        </div>

                        <small class="text-muted">Your tags:</small>
                        <a href="#" class="float-right"><small>Clear all</small></a>
                        <div class="clearfix"></div>
                        <span class="badge badge-primary badge-filter">
                            <a href="#"><i class="material-icons">close</i></a> Basic Angular
                        </span>
                        <span class="badge badge-primary badge-filter">
                            <a href="#"><i class="material-icons">close</i></a> Guide
                        </span>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
    <script>
        function deletesSecion(number,id){
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia: ¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.destroySection(number,id);
                }
            });
        }
        window.addEventListener('set-section-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
    </script>
</div>
