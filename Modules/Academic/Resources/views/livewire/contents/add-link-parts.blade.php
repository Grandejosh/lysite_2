<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses') }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>
            <li class="breadcrumb-item active"><a href="{{ route('academic_sections',$course->id) }}">{{ __('academic::labels.sections') }}</a></li>
            <li class="breadcrumb-item">{{ $section->title }}</li>
            <li class="breadcrumb-item active">{{ __('labels.Contents') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">{{ $name }}</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8">
                        <form  wire:submit.prevent="saveContentParts" class="flex mb-3">

                            <div class="form-group">
                                <label class="form-label" for="format_id">Formato *</label>
                                <div wire:ignore>
                                    <select id="format_id" class="form-control" wire:model.defer="format_id" wire:change="getParts">
                                        <option value="">Seleccionar</option>
                                        @php
                                            $university_name = '';
                                        @endphp
                                        @foreach($formats as $university)
                                            @if($university_name != $university->university_name)
                                                <optgroup label="{{ $university->university_name }}">
                                                    @foreach($formats as $format)
                                                    <option value="{{ $format->id }}">{{ $format->school_name }} / {{ $format->format_name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                            @php
                                                $university_name = $university->university_name;
                                            @endphp
                                        @endforeach
                                    </select>
                                </div>
                                @error('format_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="part_id">Parte *</label>
                                <select id="part_id" class="form-control" wire:model.defer="part_id">
                                    <option value="0">Seleccionar</option>
                                    @foreach($parts as $part)
                                    <option value="{{ $part->id }}">{{ $part->number_order }} {{ $part->description }}</option>
                                    @endforeach
                                </select>
                                @error('part_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <button wire.target="saveContentParts" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>

                        </form>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Accion</th>
                                        <th>Formato</th>
                                        <th>Index</th>
                                        <th>Descripción Parte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($content_parts) > 0)
                                        @foreach($content_parts as $k => $content_part)
                                            <tr>
                                                <td>{{ $k + 1 }}</td>
                                                <td>
                                                    <button wire:click="unlinkContentPart({{ $content_part->id }})" type="button" class="btn btn-accent btn-sm">
                                                    <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                                <td class="text-center">{{ $content_part->format_name }}</td>
                                                <td>{{ $content_part->number_order }}</td>
                                                <td>{{ $content_part->description }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="alert alert-info">No Existen registros</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-content-part-save', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })


    </script>
</div>

