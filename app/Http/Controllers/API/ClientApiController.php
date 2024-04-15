<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClientApiController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', Client::class);
        return ClientResource::collection(Client::all());
    }

     /**
     * Display the specified resource.
     * with behind the scenes laravel magic! directly pass in Taks object
     */
    public function show(Client $client)
    {
        $this->authorize('show', $client);
        return new ClientResource($client);
    }
}
