<?php

use App\Services\PaymentService;

it('processes checkout and charges the customer', function () {
    // Arrange: Mock the payment service
    $mock = $this->mock(PaymentService::class);
    $mock->shouldReceive('charge')
        ->once()
        ->with(500)
        ->andReturn([
            'success' => true,
            'transaction_id' => 'txn_test123',
            'amount' => 500,
            'currency' => 'INR',
        ]);

    // Act: Hit the checkout endpoint
    $response = $this->postJson('/checkout', [
        'amount' => 500,
    ]);

    // Assert: Check the response
    $response->assertOk()
        ->assertJson([
            'message' => 'Payment successful!',
            'transaction_id' => 'txn_test123',
        ]);
});

it('requires an amount to checkout', function () {
    $this->postJson('/checkout', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['amount']);
});

it('requires amount to be at least 100', function () {
    $this->postJson('/checkout', ['amount' => 50])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['amount']);
});

// Higher Order Tests - The Wow Factor! 🚀
it('rejects checkout without amount')
    ->postJson('/checkout', [])
    ->assertUnprocessable()
    ->assertJsonValidationErrors(['amount']);

it('rejects checkout with amount below minimum')
    ->postJson('/checkout', ['amount' => 50])
    ->assertUnprocessable();
