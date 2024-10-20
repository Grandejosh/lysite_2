<div class="modal fade" id="modalThesisHeader" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-cherry">
                <h4 class="modal-title" id="exampleModalLabel">
                    <img style="width: 50px;" src="{{ asset('theme-lyontech/images/hoja-m.png') }}" alt="">
                    HOJA DE TRABAJO
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach ($thesis as $thesi)
                        <li>
                            <a href="{{ route('worksheet', $thesi->id) }}">
                                {{ $thesi->short_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <a class="btn btn-orange" href="{{ route('investigation_thesis_create') }}"><i
                        class="fa fa-plus"></i>&nbsp;Crear Proyecto</a>
            </div>
        </div>
    </div>
</div>
