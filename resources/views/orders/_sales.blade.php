<div class="list-group">
@foreach ($order->sales as $sale)
    <a href="{{ route('items.show', $sale->item) }}" class="list-group-item">
        <span class="badge">{{ $sale->qty }}</span>
        {!! $sale->item->pic('25') !!} {{ $sale->item->title }}
    </a>
@endforeach
</div>