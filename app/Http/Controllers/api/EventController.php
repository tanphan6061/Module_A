<?php

namespace App\Http\Controllers\api;

use App\Attendee;
use App\Event;
use App\Http\Resources\EventDetailR;
use App\Http\Resources\EventR;
use App\Http\Resources\RegistrationR;
use App\Organizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function registrations(Request $request)
    {
        $attendee = Attendee::where('login_token', $request->token)->first();
        if (!$attendee) {
            return response()->json([
                'message' => 'User not logged in'
            ], 401);
        }

        return response()->json([
            'registrations' => RegistrationR::collection($attendee->registrations)
        ], 200);
    }

    public function index()
    {
        $events = Event::where('date', '>=', date('Y-m-d'))->orderBy('date')->get();
        return response()->json([
            'events' => EventR::collection($events)
        ], 200);
    }

    public function show($oSlug, $eSlug)
    {
        $organizer = Organizer::where('slug', $oSlug)->first();
        if (!$organizer) {
            return response()->json([
                'message' => 'Organizer not found'
            ], 404);
        }

        $event = $organizer->events->where('slug', $eSlug)->first();
        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
        return response()->json(new EventDetailR($event), 200);
    }

    public function registrationEvent($oSlug, $eSlug, Request $request)
    {
        $attendee = Attendee::where('login_token', $request->token)->first();
        if (!$attendee) {
            return response()->json([
                'message' => 'User not logged in'
            ], 401);
        }

        $organizer = Organizer::where('slug', $oSlug)->first();
        if (!$organizer) {
            return response()->json([
                'message' => 'Organizer not found'
            ], 404);
        }

        $event = $organizer->events->where('slug', $eSlug)->first();
        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        $check = $event->registrations->where('attendee_id', $attendee->id)->first();
        if ($check) {
            return response()->json([
                'message' => 'User already registered'
            ], 401);
        }

        $ticket = $event->tickets->find($request->ticket_id);
        if (!$ticket->available()) {
            return response()->json([
                'message' => 'Ticket is no longer available'
            ], 401);
        }

        $rg = $attendee->registrations()->create([
            'ticket_id' => $ticket->id
        ]);
        if ($request->session_ids) {
            foreach ($request->session_ids as $id) {
                $rg->session_registrations()->create([
                    'session_id' => $id
                ]);
            }
        }

        return response()->json(['message' => 'Registration successful'], 200);
    }
}
