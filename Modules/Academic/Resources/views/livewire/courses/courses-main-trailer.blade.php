<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalLabelTrailer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trailer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea wire:model.defer="trailer" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="saveChanges">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-course-open-modal-trailer', event => {
            $('#exampleModalLabelTrailer').modal('show');
        });
        window.addEventListener('aca-course-close-modal-trailer', event => {
            $('#exampleModalLabelTrailer').modal('hide');
        });
    </script>
</div>

