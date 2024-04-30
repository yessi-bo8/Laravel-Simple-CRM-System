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

    /**
     * Show the login form.
     *
     * @return View The view for the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     *
     * @param LoginUserRequest $request The request containing login data.
     * @return JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated();
            
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


    /**
     * Show the registration form.
     *
     * @return View The view for the registration form.
     */
    public function showRegistrationForm(): View
    {
        $this->authorize('register', User::class);
        return view('auth.register');
    }

    /**
     * Handle user registration.
     *
     * @param StoreUserRequest $request The request containing user registration data.
     * @return JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('register', User::class);
        $request->validated(); 

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

    /**
     * Handle user logout.
     *
     * @param Request $request The request object.
     * @return RedirectResponse The redirect response after logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Logout the user (clear session)
        Auth::logout();

        // Redirect to the home page
        return redirect('/');
    }
}
