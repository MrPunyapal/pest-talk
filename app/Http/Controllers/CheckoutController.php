<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:100'],
        ]);

        $result = $this->paymentService->charge($validated['amount']);

        return response()->json([
            'message' => 'Payment successful!',
            'transaction_id' => $result['transaction_id'],
        ]);
    }
}
