@component('mail::message')
# Order Cancelled by Customer

A customer has cancelled their order.

**Order ID:** {{ $order->id }}
**Customer:** {{ $order->customer->name }}
**Email:** {{ $order->customer->email }}
**Order Total:** {{ number_format($order->total, 2) }} {{ $order->currency ?? 'USD' }}
**Cancellation Date:** {{ now()->format('F j, Y g:i A') }}

**Reason Provided:**
{{ $order->cancellation_reason ?? 'No reason provided.' }}

@component('mail::panel')
This order has been marked as **Cancelled** in the system.
Please review if any manual actions or follow-up are required.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'warning'])
View Order Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent