@php
$title = '';

@endphp
@foreach ($thesis as $thesi)
    <HTML>
    @php
        // $d = $thesis[0]['right_margin'];
        // $l = $thesis[0]['left_margin'];
        // $m = $thesis[0]['between_lines'];
        // $t = $thesis[0]['top_margin'];
        // $b = $thesis[0]['bottom_margin'];

        
        $m = $thesi['between_lines'];
        $t = $thesi['top_margin'];
        $b = $thesi['bottom_margin'];
    @endphp

    <head>
        <title>Export</title>
        <style>
            li {
                list-style: none;
            }

            /* @page {
                margin-top: {{ $t }}cm;
                margin-bottom: {{ $b }}cm;
            } */
        </style>
    </head>

    <body style="padding: 0;margin:0">
        @if ($title != $thesi['title'])
            {{-- <h1>{{ $thesi['title'] }}</h1> --}}
            <ol>
                @foreach ($thesis as $key => $part)
                    @if ($key > 0 && $part['salto_de_pagina'])
                        <div class="page-break" style="page-break-after:always;"><span style="display:none;">&nbsp;</span></div>
                    @endif
                    @php
                    $d = $part['right_margin'];
                    $l = $part['left_margin'];
                    @endphp
                    <li style="margin-left: {{ $l }}cm;margin-right: {{ $d }}cm;padding: 0">
                        @if ($part['show_description'])
                            {{ $part['number_order'] . ' ' . $part['description'] }}
                        @endif
                        {!! $part['content'] !!}
                        {!! $part['items'] !!}
                    </li>
                @endforeach
            </ol>
        @endif
        @php
            $title = $thesi['title'];
        @endphp

    </body>

    </HTML>
@endforeach
