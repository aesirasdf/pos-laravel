<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = validator()->make($request->all(), [
            "name" => "required",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return $this->BadRequest($validator);   
        }

        $inputs = $validator->validated();

        if(!auth()->attempt($inputs)){
            return $this->Unauthorized();
        }

        $user = auth()->user();
        $token = $user->createToken("api")->plainTextToken;

        $user->profile;

        return $this->Ok($user, "Logged in success!", ["token" => $token]);
    }

    public function register(Request $request){
        $validator = validator()->make($request->all(), [
            "name" => "required|alpha_dash|min:4|max:32|unique:users",
            "password" => "required|min:8|max:64|confirmed",
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "isMale" => "required|int|min:0|max:1",
            "birth_date" => "required|date|before:tomorrow"
        ]);

        if ($validator->fails()) {
            return $this->BadRequest($validator);
        }

        $user = User::create($validator->validated());
        $user->profile()->create($validator->validated());
        $user->profile;

        return $this->Created($user, "Registered!");
    }

    public function checkToken(Request $request){
        $user = $request->user();
        $user->profile;
        return $this->Ok($user);
    }
    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return $this->Ok(null, "Logout!");
    }
}
