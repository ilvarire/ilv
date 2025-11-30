@component('mail::message')
# Payment Received 🎉

Hi {{ $name }},

We're happy to let you know that your payment has been **successfully processed**.
Thank you for shopping with **{{ config('app.name') }}**!

---

## 🧾 Order Summary
**Order ID:** {{ $order->reference }}
**Payment Amount:** {{ Number::currency($order->total_price, 'GBP') }}
**Payment Method:** {{ str($payment_method)->title() }}
**Date:** {{ $order->created_at->format('F j, Y • g:i A') }}

---

Your order is now processing. You’ll receive another update once it has been shipped.

@component('mail::button', ['url' => $url, 'color' => 'special'])
View Your Order
@endcomponent

If you have any questions, feel free to reach out—our support team is always here to help.

Thanks again for choosing **{{ config('app.name') }}**.
We truly appreciate your business!

Warm regards,
{{ config('app.name') }} Team
@endcomponent