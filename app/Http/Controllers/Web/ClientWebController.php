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
        $this->authorize('store', Client::class);
        $validatedData = $request->validated();

        if ($request->hasFile('profile_picture')) {
            // Store the uploaded image
            try {
                $filePath = $request->file('profile_picture')->store('public/uploads');
            } catch (\Exception $e) {
                Log::error('Error uploading profile picture: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload profile picture. Please try again.');
            }
        } else {
            $filePath = null;
        }

        try {

            $client = Client::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'company' => $validatedData['company'],
                'vat' => $validatedData['vat'],
                'address' => $validatedData['address'],
                'profile_picture' => $filePath,
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
        $this->authorize('update', $client);
        $validatedData = $request->validated();

        if ($request->hasFile('profile_picture')) {
            // Store the uploaded image
            try {
                $filePath = $request->file('profile_picture')->store('public/uploads');
            } catch (\Exception $e) {
                Log::error('Error uploading profile picture: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload profile picture. Please try again.');
            }
        } else {
            $filePath = null;
        }
        $validatedData['profile_picture'] = $filePath;

        try {
        Log::info('Validated data: ' . json_encode($validatedData));

        $client->update($validatedData);

        return redirect()->route('clients.index', ['client' => $client])
                        ->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update client. Please try again.');
        }

    }
}
