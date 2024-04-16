<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ClientWebController extends Controller
{
    use AuthorizesRequests;
    
    public function index() 
    {
        $this->authorize('index', Client::class);
        $clients = Client::all();
        $clients = ClientResource::collection($clients);
        return view('clients.index', ['clients'=>$clients]);
    }

    public function store(StoreClientRequest $request) 
    {
        $this->authorize('store', Client::class);
        $validatedData = $request->validated();

        $client = Client::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'company' => $validatedData['company'],
            'vat' => $validatedData['vat'],
            'address' => $validatedData['address'],
        ]);
        
        return redirect()->route('clients.index', ['client' => $client]);
    }

    public function create() 
    {
        return view('clients.create');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', ['client' => $client]);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', Client::class);
        $validatedData = $request->validated();

        Log::info('Validated data: ' . json_encode($validatedData));

        $client->update($validatedData);

        return redirect()->route('clients.index', ['client' => $client])
                        ->with('success', 'Task updated successfully');

    }


    public function destroy(Client $client)
    {
        $this->authorize('destroy', Client::class);
        $client->delete();
    }

}
