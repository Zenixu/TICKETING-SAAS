<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the organizer's events.
     */
    public function index(Request $request)
    {
        $events = Event::where('user_id', $request->user()->id)->get();

        return response()->json([
            'success' => true,
            'data' => $events
        ], 200);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'required|date',
            'location_name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'certificate_template_path' => 'nullable|string',
            'material_links' => 'nullable|array',
        ]);

        $event = Event::create([
            'user_id' => $request->user()->id,
            ...$validated
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully.',
            'data' => $event
        ], 201);
    }

    /**
     * Display the specified event.
     */
    public function show(Request $request, Event $event)
    {
        $this->authorizeAccess($request->user(), $event);

        return response()->json([
            'success' => true,
            'data' => $event
        ], 200);
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeAccess($request->user(), $event);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'sometimes|required|date',
            'location_name' => 'sometimes|required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'sometimes|required|in:draft,pending_payment,active,completed',
            'certificate_template_path' => 'nullable|string',
            'material_links' => 'nullable|array',
        ]);

        $event->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully.',
            'data' => $event
        ], 200);
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Request $request, Event $event)
    {
        $this->authorizeAccess($request->user(), $event);

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully.'
        ], 200);
    }

    /**
     * Authorize access to the event based on user role.
     */
    private function authorizeAccess($user, Event $event): void
    {
        if ($user->id !== $event->user_id) {
            abort(403, 'Unauthorized access to this event.');
        }
    }
}
