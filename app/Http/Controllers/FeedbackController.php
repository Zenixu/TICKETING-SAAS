<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FeedbackController extends BaseController
{
    /**
     * Store feedback for an event attendee.
     */
    public function store(Request $request, Attendee $attendee)
    {
        // Ensure the attendee belongs to the authenticated user
        if ($attendee->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Ensure attendee has actually checked in first
        if ($attendee->status !== 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Feedback can only be submitted after checking in.'
            ], 422);
        }

        // Check if feedback already exists for this attendee
        if ($attendee->feedback()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback has already been submitted for this attendee.'
            ], 422);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:1000',
        ]);

        $feedback = Feedback::create([
            'attendee_id' => $attendee->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback submitted successfully.',
            'data' => $feedback
        ], 201);
    }

    /**
     * Show/Download the generated e-certificate.
     */
    public function showCertificate(Request $request, Attendee $attendee)
    {
        // Ensure the attendee belongs to the authenticated user
        if ($attendee->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Must check in & fill feedback before claiming certificate
        if ($attendee->status !== 'checked_in' || !$attendee->feedback()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You must check-in and submit feedback to claim your e-certificate.'
            ], 403);
        }

        // Real code would use DOMPDF / Intervention Image to generate the certificate PDF
        return response()->json([
            'success' => true,
            'message' => 'E-Certificate download link generated.',
            'download_url' => url("/api/v1/certificates/download/{$attendee->id}.pdf")
        ], 200);
    }

    /**
     * Show event materials.
     */
    public function showMaterials(Request $request, Attendee $attendee)
    {
        // Ensure the attendee belongs to the authenticated user
        if ($attendee->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Must check in & fill feedback before accessing materials
        if ($attendee->status !== 'checked_in' || !$attendee->feedback()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You must check-in and submit feedback to access event materials.'
            ], 403);
        }

        $event = $attendee->event;

        return response()->json([
            'success' => true,
            'materials' => $event->material_links
        ], 200);
    }
}
