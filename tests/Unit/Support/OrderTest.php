<?php

use App\Support\Order;

it('applies the SAVE10 discount correctly', function () {
    $result = Order::calculateTotal(1000, 'SAVE10');

    expect($result)
        ->toBeArray()
        ->toHaveKey('total')
        ->and($result['subtotal'])->toBe(1000.0)
        ->and($result['discount'])->toBe(100.0)
        ->and($result['total'])->toBe(900.0);
});

it('calculates order total correctly', function (float $amount, string $code, float $expectedTotal) {
    $result = Order::calculateTotal($amount, $code);

    expect($result['total'])->toBe($expectedTotal);
})->with([
    'no discount code' => [1000.0, '', 1000.0],
    'SAVE10 gives 10% off' => [1000.0, 'SAVE10', 900.0],
    'HALF gives 50% off' => [1000.0, 'HALF', 500.0],
    'invalid code gives no discount' => [1000.0, 'FAKECODE', 1000.0],
    'SAVE10 on small amount' => [50.0, 'SAVE10', 45.0],
]);
