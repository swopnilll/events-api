<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Role;
use App\Models\EventParticipation;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\EventRequest;

use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
   /**
     * Display a listing of events.
     */
    public function index()
    {
        $events = Event::with('category', 'creator', 'participations', 'tickets', 'transactions')->get();
        return response()->json($events, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request): JsonResponse
    {
        // Start a database transaction
        DB::beginTransaction();
    
        try {
            // Create the event
            $event = Event::create(array_merge(
                $request->validated(),
                ['created_by' => $request->user()->id]
            ));
    
            // Fetch the admin role from the database
            $adminRole = Role::where('role_name', 'Admin')->first();
    
            if (!$adminRole) {
                throw new \Exception('Admin role not found. Please ensure roles are created.');
            }
    
            // Add the creator as a participant in the EventParticipation table
            EventParticipation::create([
                'user_id' => $request->user()->id,
                'event_id' => $event->id,
                'role_id' => $adminRole->id, // Dynamically adding admin role to creator
                'payment_status' => 'confirmed',
                'ticket_id' => null, // If a ticket is not needed for the creator
            ]);
    
            // TODO: Add logic for uploading an image to S3 and saving the URL to the events image table.

    
            // Commit the transaction if all operations succeed
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Event created successfully',
                'event' => $event,
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if any operation fails
            DB::rollBack();
    
            // Log the error for debugging
            Log::error('Error creating event: ' . $e->getMessage(), ['stack' => $e->getTrace()]);
    
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified event.
     */
    public function show($id)
    {
        $event = Event::with('category', 'creator', 'participations', 'tickets', 'transactions')->find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event, 200);
    }

    /**
     * Update the specified event.
     */
    public function update(EventRequest $request, $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        if ($event->created_by !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update this event',
            ], 403);
        }

        $event->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Event updated successfully',
            'event' => $event,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found',
            ], 404);
        }

        if ($event->created_by !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete this event',
            ], 403);
        }

        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully',
        ]);
    }
}
