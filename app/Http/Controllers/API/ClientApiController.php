<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Client;

use App\Traits\HTTPResponses;
use Illuminate\Auth\Access\AuthorizationException;

class ClientApiController extends Controller
{
    use AuthorizesRequests;
    use HTTPResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('index', Client::class);
            $clientResources = ClientResource::collection(Client::all());
        return $this->success($clientResources);
        } catch (AuthorizationException $e) {
            return $this->error(null, 'You do not have the required permissions for this operation.', 403);
        }
    }

     /**
     * Display the specified resource.
     * with behind the scenes laravel magic! directly pass in Taks object
     */
    public function show(Client $client)
    {   
        try {
            $this->authorize('show', $client);
            $clientResource = new ClientResource($client);
            return $this->success($clientResource);
        } catch (AuthorizationException $e) {
            return $this->error(null, 'You do not have the required permissions for this operation.', 403);
        }
    }

    public function destroy(Client $client)
    {
        try {
            $this->authorize('destroy', $client);
            $client->delete();
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return $this->error("", 'You do not have permission to delete this client', 403);
        } catch (\Exception $e) {
            return $this->error(null, 'Failed to delete client: ' . $e->getMessage(), 500);
        }
    }
}
