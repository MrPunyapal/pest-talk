<?php

use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;

// Approach 1: Mock the entire service class
it('processes checkout using mock', function () {
    // Arrange: Mock the entire service class
    $mock = $this->mock(PaymentService::class);
    $mock->shouldReceive('charge')
        ->once()
        ->with(500)
        ->andReturn([
            'success' => true,
            'transaction_id' => 'txn_mock123',
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
            'transaction_id' => 'txn_mock123',
        ]);
});

// Approach 2: Http::fake() - Laravel's way
it('processes checkout using Http fake', function () {
    // Arrange: Fake the HTTP response
    Http::fake([
        'api.razorpay.com/*' => Http::response([
            'success' => true,
            'transaction_id' => 'txn_fake456',
            'amount' => 500,
            'currency' => 'INR',
        ], 200),
    ]);

    // Act: Hit the checkout endpoint
    $response = $this->postJson('/checkout', [
        'amount' => 500,
    ]);

    // Assert: Check the response
    $response->assertOk()
        ->assertJson([
            'message' => 'Payment successful!',
            'transaction_id' => 'txn_fake456',
        ]);

    // BONUS: Assert the HTTP request was made correctly!
    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.razorpay.com/v1/payments'
            && $request['amount'] === 500
            && $request['currency'] === 'INR';
    });
});

it('handles payment gateway failure', function () {
    // Arrange: Fake a failed response
    Http::fake([
        'api.razorpay.com/*' => Http::response(['error' => 'Card declined'], 400),
    ]);

    // Act & Assert
    $response = $this->postJson('/checkout', [
        'amount' => 500,
    ]);

    $response->assertStatus(500);
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
