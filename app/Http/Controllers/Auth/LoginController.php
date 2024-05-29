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
use Illuminate\Support\Facades\DB;
use App\Traits\ErrorHandlingTrait;

class LoginController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;
    use ErrorHandlingTrait;

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
        try {
            $this->authorize('register', User::class);

            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['password'] = Hash::make($request->password);
            $user = User::create($validatedData);
            DB::commit();

            return $this->success([
                "user" =>$user,
                'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
            ], 'Successfully registered.'
            );
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Project", "store");
        }
    }

    /**
     * Handle user logout.
     *
     * @param Request $request The request object.
     * @return RedirectResponse The redirect response after logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();
        //Delete token
        $user->tokens()->delete();
        // Logout the user (clear session)
        Auth::logout();

        // Redirect to the home page
        return redirect('/');
    }
}
