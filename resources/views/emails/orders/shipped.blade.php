@component('mail::message')
# Order Shipped

Your order has been shipped!

@component('mail::button', ['url' => $order->trackingUrl()])
Track My Order
@endcomponent

@component('mail::button', ['url' => 'https://mandimakes.shop/my-orders/' . $order->id])
View My Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
