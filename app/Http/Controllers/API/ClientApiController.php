<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Client;

use App\Traits\HTTPResponses;
use App\Traits\ErrorHandlingTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ClientApiController extends Controller
{
    use AuthorizesRequests;
    use HTTPResponses;
    use ErrorHandlingTrait;

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
    {   try {
        $this->authorize('show', $client);
        $clientResource = new ClientResource($client);
        return $this->success($clientResource);
        } catch (ModelNotFoundException $exception) {
            return $this->error(null, 'Client not found.', 404);
        }
    }

    public function destroy(Client $client)
    {
        try {
            DB::beginTransaction();

            $this->authorize('destroy', $client);
            $client->delete();
            DB::commit();

            return $this->success(null, "Client deleted successfully.");
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Client", "store");
        }
    }
}
