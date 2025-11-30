@component('mail::message')
# Your Order Has Been Shipped!

Hi {{ $name }},

We’re happy to let you know that your order **#{{ $reference }}** has been shipped.

Your package is now on its way and is expected to arrive within:

**➡️ 10 working days**

@component('mail::panel')
If you have any questions or need assistance, feel free to contact our support team.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'special'])
View Your Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent