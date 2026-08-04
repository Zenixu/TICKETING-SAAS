<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AttendeeController extends BaseController
{
    /**
     * Display a list of attendees for an event.
     */
    public function index(Request $request, Event $event)
    {
        // Ensure the event belongs to the current organizer
        if ($request->user()->id !== $event->user_id) {
            abort(403, 'Unauthorized access to this event.');
        }

        $attendees = $event->attendees;

        return response()->json([
            'success' => true,
            'data' => $attendees
        ], 200);
    }

    /**
     * Scan QR Code and update check-in status.
     */
    public function scan(Request $request)
    {
        $validated = $request->validate([
            'qr_code_token' => 'required|string',
        ]);

        $attendee = Attendee::where('qr_code_token', $validated['qr_code_token'])->first();

        if (!$attendee) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ticket token.'
            ], 404);
        }

        // Verify authorization (Must be scanned by the event's organizer)
        $event = $attendee->event;
        if ($request->user()->id !== $event->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized scan attempt.'
            ], 403);
        }

        if ($attendee->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Attendee has already checked in.',
                'data' => $attendee
            ], 422);
        }

        $attendee->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful!',
            'data' => $attendee
        ], 200);
    }
}
