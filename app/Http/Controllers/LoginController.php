<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HTTPResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HTTPResponses;
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
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

    public function showRegistrationForm()
    {
        return view('auth.register');
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

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => "You have been succesfully logged out!"
        ]);
    }
}
