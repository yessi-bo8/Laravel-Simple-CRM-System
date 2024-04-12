<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
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
}
