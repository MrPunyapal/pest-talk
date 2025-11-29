<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    /**
     * Charge the customer's payment method.
     *
     * @throws Exception
     */
    public function charge(int $amount, string $currency = 'INR'): array
    {
        // Call the payment gateway API
        $response = Http::post('https://api.razorpay.com/v1/payments', [
            'amount' => $amount,
            'currency' => $currency,
        ]);

        if ($response->failed()) {
            throw new Exception('Payment failed: '.$response->body());
        }

        return $response->json();
    }
}
