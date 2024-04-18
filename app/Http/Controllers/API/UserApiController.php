<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HTTPResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserApiController extends Controller
{
    use AuthorizesRequests;
    use HTTPResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', User::class);
        $userResources = UserResource::collection(User::all());
        return $this->success($userResources);
    }

}