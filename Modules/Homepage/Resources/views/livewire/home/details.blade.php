<div>
    @isset($details)
    @foreach ($details as $detail)
        <div class="d-flex align-items-center">
            <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
            <p class="flex text-black-50 lh-1 mb-0"><small>{{ $detail->detail }}</small></p>
        </div>
    @endforeach
@endisset
</div>
