@component('mail::message')
# Payment Attempt Failed

A customer's payment attempt has failed.

**Order ID:** {{ $reference }}
**Customer:** {{ $name }}
**Email:** {{ $email }}
**Amount Attempted:** {{ Number::currency($total_price, 'NGN') }}
**Payment Method:** {{ $payment_method }}
**Failure Time:** {{ now()->format('F j, Y g:i A') }}

**Error / Failure Message:**
{{ $paymentError ?? 'No error message provided.' }}

@component('mail::panel')
The order is still marked as **Pending Payment**.
You may need to review this order or contact the customer if necessary.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'error'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent