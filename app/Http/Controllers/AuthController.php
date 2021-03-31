<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Enums\UserRoleTypes;

class AuthController extends Controller{
    public function register(Request $request)
    {
        $validate=Validator::make($request->toArray(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:6',
        ]);
        if ($validate->fails()){
            return response($validate->errors(), 400);
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role_id'=> UserRoleTypes::USER
        ]);
        return $this->login($request);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60*24); // 1 day

        return response([
            'message' => 'Success!'
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout()
    {
        $cookie=Cookie::forget('jwt');
        return response([
            'message'=>'Success!'
            ])->withCookie($cookie);
    }
}
