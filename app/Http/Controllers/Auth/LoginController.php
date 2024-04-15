<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\StoreUserRequest;
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

    public function login(LoginUserRequest $request)
{
    // Validate the request
    // $validatedData = $request->validated();
    $request->validated($request->all());
        
    //login and create a session
    if (!Auth::attempt(($request->only('email', 'password')))) {
        return $this->error('', 'Credentials do not match', 401);
    }

    $user = User::where('email', $request->email)->first();

    // Create a token
    $token = $user->createToken('Api Token of ' . $user->name)->plainTextToken;

    // Return the user and token data along with the redirect header
    return response()->json([
        'user' => $user,
        'token' => $token,
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
        // Logout the user (clear session)
        Auth::logout();

        // Redirect to the home page
        return redirect('/');
    }
}
