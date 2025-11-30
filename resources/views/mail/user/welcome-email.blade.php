@component('mail::message')
# Welcome to {{ config('app.name') }}!

We're excited to have you join our community. 🎉
At {{ config('app.name') }}, we’re committed to bringing you the best deals on electronics, devices, home goods,
lifestyle items, and so much more.

To help you get started, we’ve prepared a curated shopping experience designed with you in mind.

@component('mail::button', ['url' => $url, 'color' => 'special'])
Start Shopping
@endcomponent

## What you can expect:
- Exclusive discounts and early access to sales
- High-quality products across multiple categories
- Secure checkout and fast delivery
- Support from our dedicated customer care team

If you ever need help, just reply to this email — we're always here for you.

Thanks again for joining us!
We’re glad to have you onboard.

Thanks,<br>
{{ config('app.name') }}
@endcomponent