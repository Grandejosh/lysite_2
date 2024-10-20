<x-master>
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary">
            <div class="py-32pt">
                <div class="container">
                    <h1 class="text-white mb-8pt">{{ __('labels.Courses') }}</h1>
                    <span class="text-white">{{ __('labels.Edit') }}</span>
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
    @livewire('academic::contents.contents-edit',['section_id'=>$section_id, 'content_id'=>$content_id])
    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
    @section('script')
        <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/translations/sp.js"></script>
        <script>
            ClassicEditor.create( document.querySelector( '#editor' ), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable','mediaEmbed', '|', 'undo', 'redo' ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Normal', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Muy Grande', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'grande', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Mediano', class: 'ck-heading_heading3' }
                    ]
                }
            }).then(function(editor){
                editor.model.document.on('change:data', ()=>{
                    setDataText(editor.getData());
                })
            }).catch( error => {
                console.error( error );
            });
        </script>
    @endsection
</x-master>

