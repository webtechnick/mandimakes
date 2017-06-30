<div class="col-xs-6">
    <div class="hand text-center" onclick="location.href='/item/{{ $item->id }}'">
        @if ($item->hasPrimaryPhoto())
            <div class="text-center">
                {!! $item->pic(100) !!}
            </div>
        @endif
        <p>{{ $item->formattedPrice() }}</p>
    </div>
</div>
