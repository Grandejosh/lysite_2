<x-master>
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary">
            <div class="py-32pt">
                <div class="container">
                    <h1 class="text-white mb-8pt">Libro de reclamaciones</h1>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="navbar navbar-expand-sm navbar-dark-white bg-gradient-primary p-sm-0 ">
        <div class="container page__container">
            <!-- Navbar toggler -->
            <button class="navbar-toggler ml-n16pt" type="button" data-toggle="collapse" data-target="#navbar-submenu2">
                <i class="fa fa-bars"></i>
            </button>
            @livewire('nav.nav-global')
        </div>
    </div>
    @livewire('complaintbook.com-list')
    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
    <!-- Modal -->
    @section('modales')
        <div class="modal fade" id="modalDetallesLibroReclamos" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modalDetallesLibroReclamosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetallesLibroReclamosLabel">Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalDetallesLibroReclamosBody">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalReplyEmail" tabindex="-1" aria-labelledby="modalReplyEmailLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalReplyEmailLabel">Escribir mensaje de respuesta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalReplyEmailBody">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Asunto</label>
                                <input required type="text" class="form-control" name="replyAsunto" id="replyAsunto">
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="exampleFormControlInput1">Email</label>
                                    <input required type="email"class="form-control" id="replyEmail" name="replyEmail"
                                        placeholder="name@example.com">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="exampleFormControlSelect2">Estado</label>
                                    <select required class="form-control" name="replyEstado" id="replyEstado">
                                        <option value="2">Revisando</option>
                                        <option value="3">Terminado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Mensaje</label>
                                <textarea required class="form-control" name="replyMensaje" id="replyMensaje" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button onclick="saveReplyMessage()" type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-master>
