<section id="exportContent">
    @php
$title = '';
@endphp
@foreach ($thesis as $thesi)
    @if ($title != $thesi['title'])
        <ol>
        @foreach ($thesis as $key => $part)
            @if ($key > 0 && $part['salto_de_pagina'])
                <div class="page-break" style="page-break-after:always;"><span style="display:none;">&nbsp;</span></div>
            @endif
            <li style="list-style: none;">
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
@endforeach

</section>
<button onclick="Export2Word('exportContent', 'word-content.docx');">Export as .docx</button>
<script>
    function Export2Word(element, filename = ''){
        var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
        var postHtml = "</body></html>";
        var html = preHtml+document.getElementById(element).innerHTML+postHtml;

        var blob = new Blob(['\ufeff', html], {
            type: 'application/msword'
        });
        
        // Specify link url
        var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
        
        // Specify file name
        filename = filename?filename+'.doc':'document.doc';
        
        // Create download link element
        var downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob ){
            navigator.msSaveOrOpenBlob(blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = url;
            
            // Setting the file name
            downloadLink.download = filename;
            
            //triggering the function
            downloadLink.click();
        }
        
        document.body.removeChild(downloadLink);
    }
    </script> 
