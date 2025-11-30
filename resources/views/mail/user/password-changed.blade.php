@component('mail::message')
# Your Password Was Successfully Changed

Hello {{ $name ?? 'there' }},

This is a confirmation that your password for **{{ config('app.name') }}** was successfully updated.

If you made this change, no further action is required.

---

## 📌 Password Change Details

- **Date & Time:** {{ $timestamp->format('F j, Y g:i A') }} ({{ $timestamp->timezoneName }})
- **IP Address:** {{ $ip }}
- **Device / Browser:** {{ $agent }}

These details are provided for your security. If anything here looks unfamiliar, please take immediate action.

---

## ⚠️ If This Was NOT You

If you did **not** change your password, your account may be compromised.

@component('mail::button', ['url' => url('/forgot-password'), 'color' => 'error'])
Reset Password Immediately
@endcomponent

If you need additional help, feel free to contact our support team.

Thanks,<br>
{{ config('app.name') }}
@endcomponent