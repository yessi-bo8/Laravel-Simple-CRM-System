<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Traits\HTTPResponses;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\facades\Hash;

class AuthController extends Controller
{
    use HTTPResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        
        if (!Auth::attempt(($request->only('email', 'password')))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user'=> $user,
            'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all()); 

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            "user" =>$user,
            //Laravel Sanctum
            'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ]);

    }

    public function logout()
    {
        // Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => "You have been succesfully logged out!"
        ]);
    }
}
