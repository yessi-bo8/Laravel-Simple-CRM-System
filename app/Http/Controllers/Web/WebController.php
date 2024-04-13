<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    public function index() 
    {
        $clients = Client::all();
        $clients = ClientResource::collection($clients);
        $view = Route::is('projects.*') ? 'projects.index' : (Route::is('clients.*') ? 'clients.index' : 'home');
        $data = Route::is('projects.*') ? ['projects'=> ""] : (Route::is('clients.*') ? ['clients'=> $clients] : ['data'=>""]);
        return view($view, $data);
    }

    public function store(StoreClientRequest $request) 
    {
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
        // Validate the incoming request data
        $validatedData = $request->validated();
        Log::info('Validated data: ' . json_encode($validatedData));

        // Update the task with the validated data
        $client->update($validatedData);

        // Redirect the user to a relevant page or route
        return redirect()->route('clients.index', ['client' => $client])
                        ->with('success', 'Task updated successfully');

    }


    public function destroy(Client $client)
    {
        $client->delete();
    }

}
