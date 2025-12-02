@component('mail::message')
# Payment Failed

Hi {{ $name }},

Unfortunately, your recent payment attempt for **Order #{{ $reference }}** was not successful.

**Amount:** {{ Number::currency($total_price, 'NGN') }}
**Payment Method:** {{ $payment_method }}
**Date:** {{ now()->format('F j, Y g:i A') }}

@component('mail::panel')
Please re-order or try completing your payment again to avoid delays in processing your order.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'error'])
See Details
@endcomponent

If you believe this is a mistake or need assistance, feel free to contact our support team.

Thanks,<br>
{{ config('app.name') }}
@endcomponent