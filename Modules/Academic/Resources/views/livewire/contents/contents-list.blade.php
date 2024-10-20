<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('academic_courses') }}">{{ __('academic::labels.courses') }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>
            <li class="breadcrumb-item active"><a
                    href="{{ route('academic_sections', $course->id) }}">{{ __('academic::labels.sections') }}</a>
            </li>
            <li class="breadcrumb-item">{{ $section->title }}</li>
            <li class="breadcrumb-item active">{{ __('labels.Contents') }}</li>

        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Contenidos de la Sección {{ $section->title }}</p>
                        @can('academico_contenido_nuevo')
                            <a href="{{ route('academico_contenido_create', $this->section_id) }}" type="button"
                                class="btn btn-primary">Nuevo</a>
                        @endcan
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->
                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text"
                                    class="form-control search" placeholder="Search">
                                <button class="btn" type="button" role="button">
                                    <i class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th>{{ __('labels.Sort') }}</th>
                                        <th>{{ __('labels.Name') }}</th>
                                        <th>{{ __('labels.Type') }}</th>
                                        <th>{{ __('labels.Content') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($contents as $key => $content)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group">
                                                    @can('academico_contenido_editar')
                                                        <a href="{{ route('academico_contenido_editar', [$content->section_id, $content->id]) }}"
                                                            type="button" class="btn btn-info btn-sm"><i
                                                                class="fa fa-pencil-alt"
                                                                title="Ver/Editar Contenido"></i></a>
                                                    @endcan
                                                    @can('academico_contenido_enlazar')
                                                        @if ($content->content_type_id == 1)
                                                            <a href="{{ route('academico_contenido_enlazar', [$content->section_id, $content->id]) }}"
                                                                type="button" class="btn btn-success btn-sm"><i
                                                                    class="fa fa-link" title="Enlazar"></i></a>
                                                        @else
                                                                {{-- aquí si se enlaza parte del curso agregar código--}}
                                                        @endif
                                                    @endcan
                                                    @can('academico_contenido_eliminar')
                                                        <button onclick="deletes({{ $content->id }})" type="button"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash-alt"></i></button>
                                                    @endcan
                                                </div>
                                            </td>
                                            <!-- Sort -->
                                            <td class="text-center align-middle">
                                                @if ($content->count <= 1 && $count > 1)
                                                    <div role="group" aria-label="Group A">
                                                        <button
                                                            wire:click="changeordernumber('{{ $content->count }}','{{ $content->id }}', 'down')"
                                                            type="button" class="btn btn-info btn-sm"
                                                            title="{{ __('labels.Down') }}"><i
                                                                class="fas fa-angle-down"></i></button>
                                                    </div>
                                                @endif

                                                @if ($content->count > 1 && $content->count < $contents->count())
                                                    <div role="group" aria-label="Group A">
                                                        <button
                                                            wire:click="changeordernumber('{{ $content->count }}','{{ $content->id }}', 'down')"
                                                            type="button" class="btn btn-info btn-sm"
                                                            title="{{ __('labels.Down') }}"><i
                                                                class="fas fa-angle-down"></i></button>
                                                        <button
                                                            wire:click="changeordernumber('{{ $content->count }}','{{ $content->id }}', 'up')"
                                                            type="button" class="btn btn-info btn-sm"
                                                            title="{{ __('labels.Up') }}"><i
                                                                class="fas fa-angle-up"></i></button>
                                                    </div>
                                                @endif

                                                @if ($content->count == $contents->count() && $count > 1)
                                                    <div role="group" aria-label="Group A">
                                                        <button
                                                            wire:click="changeordernumber('{{ $content->count }}','{{ $content->id }}', 'up')"
                                                            type="button" class="btn btn-info btn-sm"
                                                            title="{{ __('labels.Up') }}"><i
                                                                class="fas fa-angle-up"></i></button>
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Name -->
                                            <td class="name align-middle">{{ $content->name }}
                                            </td>

                                            <td class="name align-middle">
                                                {{ $this->content_type_name($content->content_type_id) }}
                                            </td>
                                            @if ($content->content_type_id > 2)
                                                <td class="name align-middle">{{ $content->original_name }}</td>
                                            @else
                                                @if ($content->content_type_id == 2)
                                                    <td class="name align-middle">
                                                        @can('academico_contenido_editar')
                                                            <a href="{{ route('academico_contenido_editar', [$content->section_id, $content->id]) }}"
                                                                title="Ver y editar Contenido Completo">Click para ver y
                                                                editar</a>
                                                        @endcan
                                                    </td>
                                                @else
                                                    @if (strlen($content->content_url) > 120)
                                                        <td class="name align-middle">
                                                            {{ substr($content->content_url, 0, 120) }}
                                                            @can('academico_contenido_editar')
                                                                <a href="{{ route('academico_contenido_editar', [$content->section_id, $content->id]) }}"
                                                                    title="Ver y editar Contenido Completo">...</a>
                                                            @endcan
                                                        </td>
                                                    @else
                                                        <td class="name align-middle">{{ $content->content_url }}
                                                        </td>
                                                    @endif
                                                @endif
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $contents->links() }}
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container page__container">
        <input type="checkbox" wire:model="no_preguntar" name="no_preguntar" id=""><label for="no_preguntar" class="text-danger">Eliminar elementos sin preguntar</label>
    </div>
    <script>
        function deletes(id) {
            if(@this.no_preguntar){
                @this.destroy(id)
            }else{
                cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.destroy(id)
                }
            });
            }
        }
        window.addEventListener('aca-content-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
