@component('mail::message')
# Your Order Is Complete 🎉

Hello {{ $name }},

We're pleased to let you know that your order **#{{ $reference }}** has been successfully completed.

We hope you enjoy your purchase!

---

## 📝 Share Your Experience
You can now **review and comment** on the products you ordered.
Your feedback helps other customers and improves our store experience.

@component('mail::panel')
If you have any questions or need assistance, feel free to contact our support team.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'special'])
View Your Orders
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent