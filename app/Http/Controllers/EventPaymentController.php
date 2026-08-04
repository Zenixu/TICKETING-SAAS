<?php

namespace App\Http\Controllers;

use App\Models\EventPayment;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class EventPaymentController extends BaseController
{
    /**
     * Create a new payment session for event licensing.
     */
    public function store(Request $request, Event $event)
    {
        // Ensure the event belongs to the current organizer
        if ($request->user()->id !== $event->user_id) {
            abort(403, 'Unauthorized access to this event.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string|in:midtrans,xendit,manual',
        ]);

        // In a real implementation, here you would integrate with the payment gateway
        // For now, just create the payment record with 'pending' status
        $payment = EventPayment::create([
            'event_id' => $event->id,
            'transaction_id' => 'TEMP_' . strtoupper(uniqid()),
            'amount' => $validated['amount'],
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment session created.',
            'data' => $payment
        ], 201);
    }

    /**
     * Check the status of the payment for a specific event.
     */
    public function show(Request $request, Event $event)
    {
        if ($request->user()->id !== $event->user_id) {
            abort(403, 'Unauthorized access to this event.');
        }

        $payment = $event->payment;

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'No payment record found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment
        ], 200);
    }
}
