<div>
    @if($rating)
        <div wire:ignore.self>
            <div  style="cursor: pointer" class="rating rating-24">

                @for ($i; $i < $rating->rating; $i++)
                <div class="rating__item"><i class="material-icons" onclick="votar({{ $i+1 }});" value="{{ $i+1 }}">star</i></div>
                @endfor

                @if ($rating->half)
                <div class="rating__item"><i class="material-icons" onclick="votar({{ ++$i }});" value="{{ $i }}">star_half</i></div>
                @endif

                @for ($x = 0; $x < $rating->empty; $x++)
                <div onclick="votar({{ ++$i }});" class="rating__item" value="{{ $i }}"><i class="material-icons">star_border</i></div>
                @endfor

            </div>
        </div>
        <p class="lh-1 mb-0"><small class="text-muted">{{ $rating->voters }} {{ __('labels.ratings') }}</small></p>
    @endif
    <script>
        function votar(voto){
            @this.votar(voto);
        }

        window.addEventListener('aca-vote-success', event => {
                cuteAlert({
                    type: "success",
                    title: event.detail.tit,
                    message: event.detail.msg,
                    buttonText: "Okay"
                }).then(() => {
                @this.reload();
            });
            })
    </script>
</div>

