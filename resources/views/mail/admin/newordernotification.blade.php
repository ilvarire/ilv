@component('mail::message')
# New Order Pending Payment

Hello Admin,

A new order has been placed and is awaiting payment confirmation.

**Order Reference:** {{ $order->reference }}
**Total Amount:** {{ Number::currency($order->total_price, 'GBP') }}
**Order Date:** {{ $order->created_at->format('d M Y, H:i') }}

Please review the order and monitor.

@component('mail::button', ['url' => $url, 'color' => 'special'])
View Order Details
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent