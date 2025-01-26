<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Role;
use App\Models\EventParticipation;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\EventRequest;
use App\Models\EventImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;


class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        $events = Event::with('category', 'creator', 'participations', 'tickets', 'transactions', 'eventImages')->get();
        return response()->json($events, 200);
    }

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


            if ($request->hasFile('image')) {
                Log::info($request->file('image')->getClientOriginalName()); // Log the file name
                Log::info($request->file('image')->getSize()); // Log the file size

                // Proceed with the upload if file exists
                $path = Storage::disk('s3')->put('event-images', $request->file('image'));
                $url = Storage::disk('s3')->url($path);
                EventImage::create([
                    'event_id' => $event->id,
                    'image_url' => $url,
                ]);
            } else {
                return response()->json(['error' => 'No image file uploaded'], 400);
            }


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

        // dd($event); // Check if the event is updated

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

        if (!auth()->check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

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
