@component('mail::message')
# New Payment Received

A new order payment has been successfully processed.

**Order ID:** {{ $reference }}
**Customer:** {{ $email }}
**Amount Paid:** {{ Number::currency($total_price, 'NGN') }}
**Payment Method:** {{ $payment_method }}
**Date:** {{ $created_at->format('F j, Y g:i A') }}

@component('mail::panel')
This order is now marked as **Paid** and is ready for the next processing step.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'success'])
View Order Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent