<?php

namespace App\Http\Controllers;

use App\Traits\ErrorHandlingTrait;
use App\Traits\HTTPResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;
    use ErrorHandlingTrait;

    public function getToken(): 
    {
        $user = Auth::user();
        $token = $user->tokens()->first();
       
        if ($token) {
            // Retrieve the token details by ID from the personal_access_tokens table
            $tokenDetails = PersonalAccessToken::find($token->id)->token;

            // Return the token as JSON response
            return $this->success([
                'user' => $user,
                'token' => $tokenDetails,
            ], 'Successfully gotten token.');
            } else {
                return $this->error('Token not found.', 404);
            }
    }
}
