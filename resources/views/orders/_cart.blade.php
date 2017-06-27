<table class="table table-striped">
    <tr>
        <th class="text-center">Item</th>
        <th class="hidden-sm hidden-xs">Description</th>
        <th class="text-center">Quantity</th>
        <th class="text-center">Remove</th>
        <th class="text-right">Price</th>
    </tr>
    @foreach (Cart::get() as $key => $cart)
    <tr>
        <td class="text-center">
            {!! $cart->item->pic('50') !!}
        </td>
        <td class="hidden-sm hidden-xs">{!! $cart->item->short_description !!}</td>
        <td class="text-center">
            <form action="{{ route('carts.post.change', [$cart->item]) }}" method="POST" class="form-inline">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" name="qty" value="{{ $cart->qty }}" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    </span>
                </div>
            </form>
        </td>
        <td class="text-center"><a href="{{ route('carts.remove', [$cart->item]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
        <td class="text-right">{{ $cart->item->formattedPrice() }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="3" class="text-right">Sub Total: </td>
        <td colspan="2" class="text-right"> $ {{ Cart::subTotal() }}</td>
    </tr>
</table>