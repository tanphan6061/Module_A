<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Auth::user()->events->sortBy('date');
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'slug' => ['regex:/^[a-z0-9-]+$/',
                'unique' => Rule::unique('events')->where(function ($query) {
                    return $query->where('organizer_id', Auth::user()->id);
                })
            ],
            'date' => 'required|date_format:Y-m-d|after:yesterday'
        ],
            [
                'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and '-'",
                'slug.unique' => 'Slug is already used'
            ]);

        $event = Auth::user()->events()->create($data);
        return redirect()->route('events.show', $event)->with('success', 'Event successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $event->sessions = $event->rooms->map(function ($room) {
            return $room->sessions;
        })->collapse()->sortBy('start')->values();
        return view('events.detail', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'slug' => ['regex:/^[a-z0-9-]+$/',
                'unique' => Rule::unique('events')->where(function ($query) use ($event) {
                    return $query->where('organizer_id', Auth::user()->id)->where('id', '!=', $event->id);
                })
            ],
            'date' => 'required|date_format:Y-m-d|after:yesterday'
        ], [
            'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and '-'",
            'slug.unique' => 'Slug is already used'
        ]);

        $event->update($data);
        return redirect()->route('events.show', $event)->with('success', 'Event successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function report(Event $event)
    {
        $data = [];
        foreach ($event->rooms as $room) {
            foreach ($room->sessions as $session) {
                $count = $event->registrations()->count();
                if ($session->type == 'workshop')
                    $count = $session->session_registrations->count();
                $data[] = [
                    'attendees' => $count,
                    'capacity' => $room->capacity,
                    'title' => $session->title,
                    'start' => $session->start,
                ];
            }
        }
        return  view('reports.index',compact('event','data'));
    }
}
