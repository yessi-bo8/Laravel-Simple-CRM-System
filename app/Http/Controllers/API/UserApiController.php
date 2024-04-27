<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Traits\HTTPResponses;
use Illuminate\Auth\Access\AuthorizationException;

class UserApiController extends Controller
{
    use AuthorizesRequests;
    use HTTPResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('index', User::class);
        $userResources = UserResource::collection(User::all());
        return $this->success($userResources);
    }

}