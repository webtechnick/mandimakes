<table class="table table-striped">
    <tr>
        <th>Item</th><th>Description</th><th>Quantity</th><th>Price</th><th>Actions</th>
    </tr>
    @foreach (Cart::get() as $cart)
    <tr>
        <td class="text-center">pic</td>
        <td>{{ $cart->item->short_description }}</td>
        <td class="text-center">{{ $cart->qty }}</td>
        <td class="text-center">{{ $cart->item->formattedPrice() }}</td>
        <td class="text-center"><a href="/carts/remove/{{ $cart->item->id }}"><span class="glyphicon glyphicon-trash"></span></a></td>
    </tr>
    @endforeach
    <tr>
        <td colspan="3" class="text-right">Sub Total: </td>
        <td colspan="2" class="text-right"> $ {{ Cart::subTotal() }}</td>
    </tr>
</table>