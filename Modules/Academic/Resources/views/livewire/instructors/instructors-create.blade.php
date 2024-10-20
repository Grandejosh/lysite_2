



<div class="">

    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">{{ __('labels.Search and Assign Instructors') }}</h4>

                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>

                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="searchPeople" wire:model.defer="search" type="text" class="form-control search" placeholder="Search">
                                <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th>{{ __('labels.Available Instructors') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($instructors as $key => $instructor)
                                    {{-- @if ($instructor->course_id != $this->course_id) --}}
                                    <tr>
                                        <td class="text-center align-middle">{{ $key+1 }}</td>

                                        <td class="text-center align-middle">

                                            <div class="btn-group">
                                                @can('academico_instructores_asignar')

                                                <button wire:click="assign({{ $instructor->person_id }})" title="{{ __('labels.Assign') }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-angle-up"></i></button>

                                                @endcan
                                            </div>

                                        </td>
                                        <td class="name align-middle">{{ $instructor->full_name }}</td>
                                    </tr>
                                    {{-- @endif --}}
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="2">
                                            {{ $instructors->links() }}
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

</div>
