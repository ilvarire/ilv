@component('mail::message')
# Refund Processed Successfully

Hi {{ $name }},

We wanted to let you know that your refund for **Order #{{ $reference }}** has been successfully processed.

**Refund Amount:** {{ Number::currency($total_price, 'GBP') }}
**Payment Method:** {{ $payment_method }}
**Refund Date:** {{ now()->format('F j, Y g:i A') }}

@component('mail::panel')
The refunded amount has been sent back to your original payment method.
Depending on your bank or provider, it may take a few business days to appear on your statement.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'success'])
View Order Details
@endcomponent

If you have any questions regarding this refund, feel free to reach out to our support team.

Thanks,<br>
{{ config('app.name') }}
@endcomponent