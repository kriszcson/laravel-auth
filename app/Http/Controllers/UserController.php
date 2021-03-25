<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function index()
    {
        return response(UserResource::collection(User::all(), 200));
    }

    public function store(Request $request)
    {
        $user=$request->validate([
            'email'=>'required',
            'name'=>'required',
            'password'=>'required'
        ]);
        return response(User::create($user), 201);
    }

    public function show(User $user)
    {
        return response(new UserResource($user), 200);
    }

    public function update(Request $request, User $user)
    {
        $data=$request->validate([
            'email'=>'required',
            'name'=>'required',
            'password'=>'required'
        ]);
        
        $user->update($data);
        return response($user, 201 );
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 204);
    }
}
