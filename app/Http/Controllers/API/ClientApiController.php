<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Client;

use App\Traits\HTTPResponses;



class ClientApiController extends Controller
{
    use AuthorizesRequests;
    use HTTPResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', Client::class);
        $clientResources = ClientResource::collection(Client::all());
        return $this->success($clientResources);
    }

     /**
     * Display the specified resource.
     * with behind the scenes laravel magic! directly pass in Taks object
     */
    public function show(Client $client)
    {
        $this->authorize('show', $client);
        $clientResource = new ClientResource($client);
        return $this->success($clientResource);
    }

    public function destroy(Client $client)
    {
        try {
            $this->authorize('destroy', $client);
            $client->delete();
        } catch (\Exception $e) {
            return $this->error(null, 'Failed to delete client: ' . $e->getMessage(), 500);
        }
    }
}
