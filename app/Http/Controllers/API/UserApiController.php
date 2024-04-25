<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;

use App\Traits\HTTPResponses;
use Illuminate\Auth\Access\AuthorizationException;

class UserApiController extends Controller
{
    use AuthorizesRequests;
    use HTTPResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('index', User::class);
            $userResources = UserResource::collection(User::all());
            return $this->success($userResources);
        } catch (AuthorizationException $e) {
        return $this->error(null, 'You do not have the required permissions for this operation', 403);
        }
    }

}