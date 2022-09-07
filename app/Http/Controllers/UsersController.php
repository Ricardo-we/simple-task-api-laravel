<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Utils\ResponseFormatter;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function store(Request $request)
    {
        $data =  $request->validate([
            "name" => "required|max:255",
            "password" => "required|max:255|min:6",
            "email" => "required|unique:users|email"
        ]);
        
        $user = User::create([
            "name" => $data["name"],
            "password" => bcrypt($data["password"]),
            "email" => $data["email"]
        ]);

        $token = $user->createToken(getenv("USER_TOKEN_HASH"))->plainTextToken;
        
        return response([
            "user" => $user,
            "token" => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $user = User::where("email", $data["email"])->first();

        if(!$user){
            return  ResponseFormatter::errorResponse("User not found", 404);
        } else if(!Hash::check($data["password"], $user->password)){
            return  ResponseFormatter::errorResponse("Invalid password", 403);
        }

        $token = $user->createToken(getenv("USER_TOKEN_HASH"))->plainTextToken;

        return response(
            [
                "user" => $user,
                "token" => $token
            ], 
            200
        );

    }

    public function logout(Request $request) 
    {
        auth()->user()->tokens()->delete();

        return ["message" => "Success"];
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
