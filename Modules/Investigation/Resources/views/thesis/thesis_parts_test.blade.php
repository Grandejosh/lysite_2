<x-master>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="{{ url('ckeditor/nouislider.css') }}">
    {{-- <link rel="stylesheet" href="{{ url('richtexteditor/rte_theme_default.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('richtexteditor/style.css') }}" /> --}}
    <style type="text/css">
        .ventana_flotante {
            background: none repeat scroll 0 0 #FFFFFF;
            border: 1px solid #DDDDDD;
            border-radius: 5px 5px 5px 5px;
            bottom: 10px;
            left: auto;
            margin-left: 5px;
            padding: 0px 0 0;
            position: fixed;
            text-align: center;
            width: 320px;
            z-index: 15;
        }
        .index-modal-contenido{
            background-color:aqua;
            width:300px;
            padding: 10px 20px;
            margin: 20% auto;
            position: relative;
        }
        .index-modal{
            background-color: rgba(0,0,0,.8);
            position:fixed;
            top:0;
            right:0;
            bottom:0;
            left:0;
            opacity:0;
            pointer-events:none;
            transition: all 1s;
            z-index: 99999999;
        }
        #modalIndexTesis:target{
            opacity:1;
            pointer-events:auto;
        }
    </style>
    @stop
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary">
            <div class="py-32pt">
                <div class="container">
                    <h1 class="text-white mb-8pt">{{ __('investigation::labels.thesis') }}</h1>
                    <p class="lead text-white-50 measure-hero-lead mb-24pt">
                        {{ __('investigation::labels.parts_the_thesis') }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="navbar navbar-expand-sm navbar-dark-white bg-gradient-primary p-sm-0 ">
        <div class="container page__container">
            <button class="navbar-toggler ml-n16pt" type="button" data-toggle="collapse" data-target="#navbar-submenu2">
                <i class="fa fa-bars"></i>
            </button>
            @livewire('nav.nav-global')
        </div>
    </div>
    @livewire('investigation::thesis.thesis-parts-test',['thesis_id' => $thesis_id, 'sub_part' => $sub_part])
    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
    @section('script')
        {{-- <script src="{{ asset('ckeditor-4/ckeditor.js') }}"></script>
        <script src="{{ asset('ckeditor-4/config.js') }}"></script>
        <script src="{{ asset('ckfinder/ckfinder.js') }}"></script> --}}

        {{-- <script src="{{ url('ckeditor5/build/ckeditor.js') }}"></script> --}}
        {{-- <script type="text/javascript" src="{{ url('richtexteditor/rte.js') }}"></script>
        <script type="text/javascript" src="{{ url('richtexteditor/plugins/all_plugins.js') }}"></script> --}}
    @endsection
</x-master>








