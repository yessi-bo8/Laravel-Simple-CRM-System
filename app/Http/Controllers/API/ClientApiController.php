<?php

namespace App\Http\Controllers\API;

use App\Exceptions\DeleteException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Traits\HTTPResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


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
            throw new DeleteException("Failed to delete client: " . $e->getMessage());
        }
    }
}
