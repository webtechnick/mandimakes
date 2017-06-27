<table class="table table-striped">
    <tr>
        <th class="text-center">Item</th>
        <th class="hidden-sm hidden-xs">Description</th>
        <th class="text-center">Quantity</th>
        <th class="text-right">Price</th>
    </tr>
    @foreach ($order->sales as $sale)
    <tr>
        <td class="text-center">{!! $sale->item->pic('50') !!}</td>
        <td class="hidden-sm hidden-xs">{!! $sale->item->short_description !!}</td>
        <td class="text-center">{{ $sale->qty }}</td>
        <td class="text-right">{{ $sale->item->formattedPrice() }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="3" class="text-right">Tax:</td>
        <td class="text-right">{{ format_price($order->tax_dollars) }}</td>
    </tr>
    @if ($order->discount_dollars)
    <tr>
        <td colspan="3" class="text-right">Discount:</td>
        <td class="text-right">{{ format_price($order->discount_dollars) }}</td>
    </tr>
    @endif
    <tr>
        <td colspan="3" class="text-right">Shipping:</td>
        <td class="text-right">{{ format_price($order->shipping_dollars) }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"><strong>Total:</strong></td>
        <td class="text-right"><strong>{{ format_price($order->total_dollars) }}</strong></td>
    </tr>
</table>