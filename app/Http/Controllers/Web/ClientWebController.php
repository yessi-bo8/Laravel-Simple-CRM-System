<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Services\ClientService;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Traits\ErrorHandlingTrait;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientWebController extends Controller
{
    use AuthorizesRequests;
    use ErrorHandlingTrait;

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    
    public function index(): View 
    {
        $this->authorize('index', Client::class);
        $clients = Client::all();
        $clients = ClientResource::collection($clients);
        return view('clients.index', ['clients'=>$clients]);
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        try {
            $this->authorize('store', Client::class);
            $validatedData = $request->validated();
            $filePath = $this->clientService->handleProfilePictureUpload($request);

            DB::beginTransaction();
            $client = Client::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'company' => $validatedData['company'],
                'vat' => $validatedData['vat'],
                'address' => $validatedData['address'],
                'profile_picture' => $filePath,
            ]);
            DB::commit();
            return redirect()->route('clients.index', ['client' => $client])->with('success', 'Client created successfully');;
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Client", "store");
        }
    }

    public function create(): View
    {
        $this->authorize('store', Client::class);
        return view('clients.create');
    }

    public function edit(Client $client): View
    {
        $this->authorize('update', $client);
        return view('clients.edit', ['client' => $client]);
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse  
    {
        try {
            $this->authorize('update', $client);
            $validatedData = $request->validated();
            $filePath = $this->clientService->handleProfilePictureUpload($request);
            $validatedData['profile_picture'] = $filePath;

            DB::beginTransaction();
            Log::info('Validated data: ' . json_encode($validatedData));

            $client->update($validatedData);
            DB::commit();
            return redirect()->route('clients.index', ['client' => $client])
                        ->with('success', 'Client updated successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Client", "update");
        }

    }
}
