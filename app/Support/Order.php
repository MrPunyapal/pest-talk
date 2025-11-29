<?php

declare(strict_types=1);

namespace App\Support;

class Order
{
    /**
     * Calculate order total with optional discount code.
     *
     * @return array{subtotal: float, discount: float, total: float}
     */
    public static function calculateTotal(float $amount, string $discountCode = ''): array
    {
        $discount = 0.0;

        if ($discountCode === 'SAVE10') {
            $discount = $amount * 0.10;
        } elseif ($discountCode === 'HALF') {
            $discount = $amount * 0.50;
        }

        return [
            'subtotal' => $amount,
            'discount' => $discount,
            'total' => $amount - $discount,
        ];
    }
}
