@component('mail::message')
# Order Cancelled

Hi {{ $name }},

We’re writing to inform you that **Order #{{ $reference }}** has been cancelled.

**Reason for Cancellation:**
{{ $cancellation_reason ?? 'Not specified' }}

**Order Total:** {{ Number::currency($total_price, 'NGN') }}

@component('mail::panel')
If you made a payment, any eligible refunds will be processed according to our refund policy.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'special'])
View Order Details
@endcomponent

If you believe this cancellation was a mistake or need help placing a new order, our support team is happy to help.

Thanks,<br>
{{ config('app.name') }}
@endcomponent