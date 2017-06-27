<ul class="list-group">
@foreach ($order->sales as $sale)
    <li class="list-group-item">
        <span class="badge">{{ $sale->qty }}</span>
        {!! $sale->item->pic('25') !!} {{ $sale->item->title }}
    </li>
@endforeach
</ul>