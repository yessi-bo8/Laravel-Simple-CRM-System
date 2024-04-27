<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

use App\Models\User;

use App\Traits\HTTPResponses;


class LoginController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated($request->all());
            
        //login and create a session
        if (!Auth::attempt(($request->only('email', 'password')))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        // Create a token
        $token = $user->createToken('Api Token of ' . $user->name)->plainTextToken;

        // Return the user and token data
        return $this->success([
            'user' => $user,
            'token' => $token,
        ], 'Successfully logged in.');
    }


    public function showRegistrationForm(): View
    {
        $this->authorize('register', User::class);
        return view('auth.register');
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('register', User::class);
        $request->validated($request->all()); 

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            "user" =>$user,
            'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ], 'Successfully registered.'
        );
    }

    public function logout(Request $request): RedirectResponse
    {
        // Logout the user (clear session)
        Auth::logout();

        // Redirect to the home page
        return redirect('/');
    }
}
