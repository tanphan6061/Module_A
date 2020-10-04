<?php

namespace App\Http\Controllers;

use App\Event;
use App\Room;
use App\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Event $event
     * @return void
     */
    public function create(Event $event)
    {
        return view('sessions.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Event $event
     * @return void
     */
    public function store(Request $request, Event $event)
    {
        $data = $this->validate($request, [
            'type' => 'required|in:talk,workshop',
            'title' => 'required',
            'speaker' => 'required',
            'room_id' => 'required',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
            'description' => 'required'
        ]);

        $data['cost'] = null;
        if ($request->type == 'workshop') {
            $data['cost'] = $request->cost;
            $this->validate($request, ['cost' => 'required|numeric|min:0']);
        }

        $room = Room::find($request->room_id);
        $check = $room->sessions->filter(function ($ss) use ($data) {
            return !(($data['end'] > $data['start']) && ($data['end'] <= $ss->start || $data['start'] >= $ss->end));
        })->count();

        if ($check > 0) {
            return redirect()->back()->withErrors(['room_id' => 'Room already booked during this time']);
        }

        Session::create($data);
        return redirect()->route('events.show', $event)->with('success', 'Session successfully created');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Session $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Session $session
     * @param Event $event
     * @return void
     */
    public function edit(Event $event, Session $session)
    {
        return view('sessions.edit', compact('event', 'session'));   //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Session $session
     * @param Event $event
     * @return void
     */
    public function update(Request $request, Event $event, Session $session)
    {
        $data = $this->validate($request, [
            'type' => 'required|in:talk,workshop',
            'title' => 'required',
            'speaker' => 'required',
            'room_id' => 'required',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
            'description' => 'required'
        ]);

        $data['cost'] = null;
        if ($request->type == 'workshop') {
            $data['cost'] = $request->cost;
            $this->validate($request, ['cost' => 'required|numeric|min:0']);
        }

        $room = Room::find($request->room_id);
        $check = $room->sessions->filter(function ($ss) use ($data, $session) {
            return !(($data['end'] > $data['start']) && ($data['end'] <= $ss->start || $data['start'] >= $ss->end)) && ($session->id != $ss->id);
        })->count();

        if ($check > 0) {
            return redirect()->back()->withErrors(['room_id' => 'Room already booked during this time']);
        }

        $session->update($data);
        return redirect()->route('events.show', $event)->with('success', 'Session successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Session $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
}
