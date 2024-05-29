<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use App\Models\User;
use App\Traits\ErrorHandlingTrait;
use App\Traits\HTTPResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;


class GoogleAuthController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;
    use ErrorHandlingTrait;
    

    public function redirect()
    {
        return Socialite::driver('Google')->redirect();

    }

    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);

                Auth::login($new_user);
                $new_user->createToken('Api Token of ' . $new_user->name)->plainTextToken;

                return view('auth.token')->with('success', 'Successfully logged in.');

            } else {
                Auth::login($user);

                $user->createToken('Api Token of ' . $user->name)->plainTextToken;

                return view('auth.token')->with('success', 'Successfully logged in.');

            }
        } catch (InvalidStateException $e) {
            return redirect('/login')->with('error', 'Invalid state, please try again.');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login canceled or an error occurred during login.');
        }
    }
}
