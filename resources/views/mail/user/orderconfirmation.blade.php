@component('mail::message')


# Your Order is Pending Confirmation

Thank you for your recent order!

We have received your order, which totals **{{ Number::currency($order->total_price, 'NGN') }}**, but we are still
waiting for payment confirmation.

Your order reference number is **{{ $order->reference }}**.

@component('mail::button', ['url' => $url])
View Payment Details
@endcomponent

We appreciate your choice to shop with **{{ config('app.name') }}**! If you have any questions or need assistance,
please don't hesitate to reach out to our support team.

Best regards,
The **{{ config('app.name') }}** Team
@endcomponent