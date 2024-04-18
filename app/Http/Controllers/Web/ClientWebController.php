<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

use App\Http\Resources\ClientResource;

use App\Models\Client;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        try {
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
        } catch (\Exception $e) {
            Log::error('Error storing client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to store client. Please try again.');
        }
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
        try {
        $this->authorize('update', $client);
        $validatedData = $request->validated();

        Log::info('Validated data: ' . json_encode($validatedData));

        $client->update($validatedData);

        return redirect()->route('clients.index', ['client' => $client])
                        ->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update client. Please try again.');
        }

    }


    public function destroy(Client $client)
    {
        try {
            $this->authorize('destroy', $client);
            $client->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete client. Please try again.');
        }
    }

}
