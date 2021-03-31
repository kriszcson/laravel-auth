<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        return response(EventResource::collection(Event::all(), 200));
    }

    public function store(Request $request)
    {
        if ($request['user_id']!=NULL && $request['user_id'] != Auth::user()['id']
            && Auth::user()['role_id']!=1){
            return response(['message'=>'No permission!'], 403);
        }     
        $validate=Validator::make($request->toArray(),[
            'day'=>'required',
            'event_type'=>'required',
            'comment'=>'nullable',
            'user_id'=>'nullable'
        ]);
        if ($validate->fails()){
            return response($validate->errors(), 400);
        }
            return response(Event::create([
                'day' => $request->input('day'),
                'event_type' => $request->input('event_type'),
                'comment' => $request->input('comment'),
                'user_id'=> $request['user_id'] 
                ?  $request['user_id']
                : Auth::user()['id']
            ]), 201);
        } 

    public function show(Event $event)
    {
        return response(new EventResource($event), 200);
    }

    public function update(Request $request, Event $event)
    { 
        if (($request['user_id']!=NULL || $event['user_id'] != Auth::user()['id'])
            && Auth::user()['role_id']!=1){
            return response(['message'=>'No permission!'], 403);
        }
        $validate=Validator::make($request->toArray(),[
            'day'=>'nullable',
            'event_type'=>'nullable',
            'comment'=>'nullable',
            'user_id'=>'nullable'
        ]);
        if ($validate->fails()){
            return response($validate->errors(), 400);
        }
        $event->update($validate->validate());

        return response($event, 201);
    }

    public function destroy(Event $event)
    {
        if ($event['user_id'] != Auth::user()['id'] && Auth::user()['role_id']!=1){
            return response(['message'=>'No permission!'], 403);
        }
        $event->delete();
        return response(null, 204);
    }
}
