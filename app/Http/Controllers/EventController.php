<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index()
    {
        return response(EventResource::collection(Event::all(), 200));
    }

    public function store(Request $request)
    {
        $data=$request->validate([
        'event_type'=>'required',
        'day' =>'required',
        'user_id'=>'required'
        ]);
        return response(Event::create($data), 201);
    }

    public function show(Event $event)
    {
        return response(new EventResource($event), 200);
    }

    public function update(Request $request, Event $event)
    {
        $data=$request->validate([
            'event_type'=>'required',
            'day' =>'required',
            'user_id'=>'required',
            'comment'=>'required'
        ]);
        $event->update($data);
        return response($event, 201 );
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response(null, 204);
    }
}
