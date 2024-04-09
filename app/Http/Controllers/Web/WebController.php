<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    public function index() 
    {
        $view = Route::is('projects.*') ? 'projects.index' : (Route::is('clients.*') ? 'clients.index' : 'home');
        return view($view);
    }

    public function create() 
    {
        $view = Route::is('projects.*') ? 'projects.create' : (Route::is('clients.*') ? 'clients.create' : '');
        $projects = Project::all();
        $clients = Client::all();
        return view($view, ['clients' => $clients, 'projects' => $projects]);
    }


}
