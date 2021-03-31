<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Enums\UserRoleTypes;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()['role_id']==1){
            return response(UserResource::collection(User::all(), 200));
        } else {
            return response(['message'=>'No permission!'], 403);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()['role_id']==1){
            return response(User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role_id'=> $request->input('role_id')!=NULL
                    ? $request->input('role_id')
                    : UserRoleTypes::USER,
            ]), 201);
        } else {
            return response(['message'=>'No permission!'], 403);
        }   
    }


    public function show(User $user)
    {
        if (Auth::user()['id']==$user['id'] || Auth::user()['role_id']==1 ){
            return response(new UserResource($user), 200);
        } else {
            return response(['message'=>'No permission!'], 403);
        }
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()['id']==$user['id'] || Auth::user()['role_id']==1 ){
        $validate=Validator::make($request->toArray(),[
                'name'=>'nullable',
                'email'=>'nullable',
                'password'=>'nullable'
        ]);
        if ($validate->fails()){
            return response($validate->errors(), 400);
        }
        $user->update($validate->validate());
            return response($user, 201);
        } else {
            return response(['message'=>'No permission!'], 403);
        }
    }

    public function destroy(User $user)
    {
        if (Auth::user()['id']==$user['id'] || Auth::user()['role_id']==1 ){
            $user->delete();
            return response(null, 204);
        } else {
            return response(['message'=>'No permission!'], 403);
        }
    }
}
