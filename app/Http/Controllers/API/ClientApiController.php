<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use Illuminate\Http\JsonResponse;

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
     *
     * @return JsonResponse The JSON response containing the list of clients.
     */
    public function index(): JsonResponse
    {
        $this->authorize('index', Client::class);
        $clientResources = ClientResource::collection(Client::all());
        return $this->success($clientResources);
    }

     /**
     * Display the specified resource.
     *
     * @param Client $client The client instance to be displayed.
     * @return JsonResponse The JSON response containing the client data.
     */
    public function show(Client $client): JsonResponse
    {   
        try {
            $this->authorize('show', $client);
            $clientResource = new ClientResource($client);
            return $this->success($clientResource);
        } catch (ModelNotFoundException $exception) {
            return $this->error(null, 'Client not found.', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client The client instance to be deleted.
     * @return JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function destroy(Client $client): JsonResponse
    {
        try {
            $this->authorize('destroy', $client);

            DB::beginTransaction();
            $client->delete();
            DB::commit();

            return $this->success(null, "Client deleted successfully.");
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Client", "delete");
        }
    }
}
