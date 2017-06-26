@component('mail::message')
# Order Received

Thank you for your order, it will be processed and shipped soon!

@component('mail::button', ['url' => 'https://mandimakes.shop/my-orders'])
View My Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
