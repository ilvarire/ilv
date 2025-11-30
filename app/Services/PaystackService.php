<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    public function initializePayment($email, $amount, $reference, $callbackUrl)
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
                'email' => $email,
                'amount' => $amount * 100, // Paystack accepts in kobo
                'reference' => $reference,
                'callback_url' => $callbackUrl,
            ]);

        return $response->json();
    }

    public function verifyPayment($reference)
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get(config('services.paystack.payment_url') . '/transaction/verify/' . $reference);

        return $response->json();
    }
}
