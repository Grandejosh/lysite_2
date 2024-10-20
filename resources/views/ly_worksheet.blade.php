@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ckeditor-docs.css') }}">

@stop
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>
        <!-----fsfdsfds-->
        <div class="media mt-4">
            <div class="container">
                <div class="row ">
                    <div class="col-md-6 col-sm-12 offset-md-3 d-flex justify-content-center align-items-center">
                        <div class="image-der mr-3">
                            <img src="{{ asset('theme-lyontech/images/hoja-m.png') }}" alt="Card image cap"
                                style="width: 100px; margin: auto;">
                        </div>
                        <div class="texto">
                            <h5 class="mb-0" style="margin-left: -10px;">
                                <strong style="font-size: 1.8rem;letter-spacing: 0.0em;">HOJA DE TRABAJO</strong>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="xurl_thesis" value="{{ route('investigation_thesis_export_word_ckeditor', [$thesis_id]) }}">

        <livewire:investigation::thesis.ly-thesis-parts :thesis_id="$thesis_id" :sub_part="$sub_part" />



    </body>

@stop

@section('script')

    <script src="{{ asset('ckeditor5/build/ckeditor.js') }}"></script>
    <script>
        function openModalIndexes() {
            $('#modalIndexes').modal('show');
        }
    </script>
@endsection

@section('global-modal')
    <livewire:investigation::indexes.ly-indexes-modal :thesis_student_id="$thesis_id" />
@stop
