<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

class PaymentService
{
    /**
     * Charge the customer's payment method.
     *
     * @throws Exception
     */
    public function charge(int $amount, string $currency = 'INR'): array
    {
        // In reality, this calls Razorpay/Stripe API
        // We NEVER want tests to hit this!

        return [
            'success' => true,
            'transaction_id' => 'txn_'.uniqid(),
            'amount' => $amount,
            'currency' => $currency,
        ];
    }
}
