<?php

namespace App\Http\Controllers;

use App\Event;
use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('tickets.create', compact('event'));
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
        //
        $data = $request->only('name', 'cost');
        $rules = [
            'name' => 'required',
            'cost' => 'required|numeric|min:0'
        ];

        if ($request->special_validity == 'amount') {
            $data['special_validity'] = json_encode(['type' => 'amount', 'amount' => $request->amount]);
            $rules['amount'] = 'required|numeric|min:0';
        } else if ($request->special_validity == 'date') {
            $data['special_validity'] = json_encode(['type' => 'date', 'date' => $request->date]);
            $rules['date'] = 'required|date_format:Y-m-d H:i';
        }

        $this->validate($request, $rules);
        $event->tickets()->create($data);
        return redirect()->route('events.show', $event)->with('success', 'Ticket successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
